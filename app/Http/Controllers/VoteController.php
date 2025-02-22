<?php

namespace App\Http\Controllers;

use App\Events\VoteCast;
use App\Models\PollOption;
use App\Services\VoteService;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    protected $voteService;

    /**
     * Inject the VoteService into the controller.
     *
     * @param VoteService $voteService The service that handles voting logic.
     */
    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    /**
     * Handles a user's vote submission.
     *
     * @param Request $request The HTTP request containing user details.
     * @param int $pollOptionId The ID of the selected poll option.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     */
    public function vote(Request $request, int $pollOptionId)
    {
        // Retrieve the user's IP address
        $userIp = $request->ip();

        // Find the poll option or return 404 if not found
        $pollOption = PollOption::find($pollOptionId);

        if (!$pollOption) {
            return response()->json(['error' => 'Poll option not found.'], 404);
        }

        // Check if the user has already voted in this poll
        if ($this->voteService->hasUserVoted($pollOption->poll_id, $userIp)) {
            return response()->json(['message' => 'You have already voted!'], 403);
        }

        // Cast the user's vote
        $this->voteService->castVote($pollOption, $userIp);

        event(new VoteCast($pollOption));

        return response()->json(['message' => 'Vote recorded successfully!']);
    }
}

