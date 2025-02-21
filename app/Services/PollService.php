<?php
namespace App\Services;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            $poll = Poll::create([
                'question' => $question,
                'slug'  => $this->generateUniqueSlug($question),
            ]);
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
     * Update a poll with new question and options.
     *
     * @param Poll $poll The poll to update.
     * @param string $question The new poll question.
     * @param array $options The updated list of poll options.
     * @return Poll The updated poll.
     */
    public function updatePoll(Poll $poll, string $question, array $options): Poll
    {
        return DB::transaction(function () use ($poll, $question, $options) {
            // Update poll question
            $poll->update(['question' => $question]);

            // Fetch existing poll options (id => text)
            $existingOptions = $poll->options()->pluck('option_text', 'id')->toArray();

            // Separate options into new, updated, and deleted categories
            $newOptions = collect($options);
            $optionsToUpdate = [];
            $optionsToDelete = array_diff($existingOptions, $newOptions->toArray());
            $optionsToInsert = $newOptions->diff($existingOptions);

            // Update existing options (only if text has changed)
            foreach ($existingOptions as $id => $text) {
                if ($newOptions->contains($text)) {
                    continue; // Skip if unchanged
                }

                // Find a matching option and update it
                if ($newOptions->search(fn($newText) => $newText === $text) === false) {
                    $updatedText = $newOptions->first();
                    $optionsToUpdate[$id] = ['option_text' => $updatedText];
                    $newOptions = $newOptions->reject(fn($newText) => $newText === $updatedText);
                }
            }

            // Perform batch update for modified options
            foreach ($optionsToUpdate as $id => $data) {
                PollOption::where('id', $id)->update($data);
            }

            // Delete removed options
            $poll->options()->whereIn('option_text', $optionsToDelete)->delete();

            // Insert new options
            $poll->options()->createMany(
                collect($optionsToInsert)->map(fn($text) => ['option_text' => $text])->toArray()
            );

            return $poll;
        });
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

    /**
     * Delete a poll and its associated options.
     *
     * @param Poll $poll The poll to delete.
     * @return bool Whether the deletion was successful.
     */
    public function deletePoll(Poll $poll): bool
    {
        return DB::transaction(function () use ($poll) {
            // Delete all related poll options first
            $poll->options()->delete();

            // Delete the poll itself
            return $poll->delete();
        });
    }

    /**
     * Generate poll slug
     *
     * @param   string  $question  Poll question
     *
     * @return  string Generated unique slug
     */
    private function generateUniqueSlug($question)
    {
        $slug = Str::slug($question);
        $count = Poll::where('slug', 'like', $slug . '%')->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
