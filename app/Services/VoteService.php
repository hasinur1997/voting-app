<?php
namespace App\Services;

use App\Models\PollOption;
use App\Models\Vote;

class VoteService
{
    /**
     * Check if the user has already voted in the given poll.
     *
     * @param int $pollId The ID of the poll.
     * @param string $userIp The user's IP address.
     * @return bool Returns true if the user has already voted, false otherwise.
     */
    public function hasUserVoted(int $pollId, string $userIp): bool
    {
        return Vote::where('poll_id', $pollId)
                   ->where('user_ip', $userIp)
                   ->exists();
    }

    /**
     * Records a vote for a given poll option.
     *
     * @param PollOption $pollOption The selected poll option.
     * @param string $userIp The IP address of the user casting the vote.
     * @return void
     */
    public function castVote(PollOption $pollOption, string $userIp): void
    {
        // Store the vote in the database
        Vote::create([
            'poll_id' => $pollOption->poll_id,
            'poll_option_id' => $pollOption->id,
            'user_ip' => $userIp,
        ]);

        // Increment the vote count for the selected option
        $pollOption->increment('votes');
    }
}
