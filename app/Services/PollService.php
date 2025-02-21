<?php
namespace App\Services;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Facades\DB;

class PollService
{
    /**
     * Create a new poll with options.
     *
     * @param string $question The poll question.
     * @param array $options The list of poll options.
     * @return Poll The created poll.
     */
    public function createPoll(string $question, array $options): Poll
    {
        return DB::transaction(function () use ($question, $options) {
            $poll = Poll::create(['question' => $question]);
            $poll->options()->createMany(
                collect($options)->map(fn($option) => ['option_text' => $option])->toArray()
            );

            return $poll; // Transaction commits only if everything succeeds
        });
    }

    /**
     * Retrieve a poll along with its options.
     *
     * @param int $pollId The ID of the poll.
     * @return Poll|null The retrieved poll or null if not found.
     */
    public function getPoll(int $pollId): ?Poll
    {
        return Poll::with('options')->find($pollId);
    }

    /**
     * List all polls with their options.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of polls.
     */
    public function listPolls()
    {
        return Poll::with('options')->get();
    }
}
