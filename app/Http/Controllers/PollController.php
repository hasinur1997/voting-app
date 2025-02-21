<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PollOption;
use App\Http\Requests\StorePollRequest;
use App\Services\PollService;

class PollController extends Controller
{
    protected $pollService;

    /**
     * Inject the PollService into the controller.
     *
     * @param PollService $pollService The service handling poll logic.
     */
    public function __construct(PollService $pollService)
    {
        $this->pollService = $pollService;
    }

    /**
     * Retrieve a list of all polls.
     *
     * @return \Illuminate\Http\JsonResponse JSON response with a list of polls.
     */
    public function index()
    {
        $polls = $this->pollService->listPolls();

        return Inertia::render('Polls/Index', ['polls' => $polls]);
    }

    /**
     * Show the form for creating poll.
     */
    public function create()
    {
        return Inertia::render('Polls/Create');
    }

    /**
     * Create a new poll with multiple options.
     *
     * @param Request $request The HTTP request containing poll data.
     * @return \Illuminate\Http\JsonResponse JSON response with the created poll details.
     */
    public function store(StorePollRequest $request)
    {

        $poll = $this->pollService->createPoll($request->question, $request->options);

        return response()->json(['message' => 'Poll created successfully!', 'poll' => $poll], 201);
    }

    /**
     * Retrieve and display a specific poll.
     *
     * @param int $id The ID of the poll.
     * @return \Illuminate\Http\JsonResponse JSON response with poll details.
     */
    public function show(Poll $poll)
    {
        return Inertia::render('Polls/Show', compact('poll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poll $poll)
    {
        return Inertia::render('Polls/Edit', compact('poll'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poll $poll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poll $poll)
    {
        //
    }
}
