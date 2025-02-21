<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PollService;

class ListPollsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poll:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display a list of polls with their options';

    /**
     * The poll service instance.
     *
     * @var PollService
     */
    protected PollService $pollService;

    /**
     * ListPollsCommand constructor.
     *
     * @param PollService $pollService
     */
    public function __construct(PollService $pollService)
    {
        parent::__construct();
        $this->pollService = $pollService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Retrieve all polls with their options
        $polls = $this->pollService->listPolls();

        // Check if there are no polls available
        if ($polls->isEmpty()) {
            $this->warn('No polls found.');
            return;
        }

        // Iterate through each poll and display formatted output
        foreach ($polls as $poll) {
            $this->info("Poll ID: {$poll->id}");
            $this->line("Question: {$poll->question}");
            $this->line("Slug: {$poll->slug}");
            $this->line("Options:");

            // Format options in a table format
            $options = $poll->options->map(fn($option) => [
                'Option ID' => $option->id,
                'Option Text' => $option->option_text,
                'Votes' => $option->votes ?? 0
            ])->toArray();

            $this->table(['Option ID', 'Option Text', 'Votes'], $options);

            $this->line(str_repeat('-', 40)); // Separator line
        }
    }
}
