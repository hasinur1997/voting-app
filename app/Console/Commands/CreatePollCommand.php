<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PollService;

class CreatePollCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poll:create {question : The poll question} {options* : The poll options}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new poll with multiple options';

    /**
     * The poll service instance.
     *
     * @var PollService
     */
    protected PollService $pollService;

    /**
     * CreatePollCommand constructor.
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
        // Retrieve question and options from command arguments
        $question = $this->argument('question');
        $options = $this->argument('options');

        // Validate input
        if (empty($question) || count($options) < 2) {
            $this->error('Poll must have a question and at least two options.');
            return;
        }

        // Call PollService to create the poll
        $poll = $this->pollService->createPoll($question, $options);

        // Output success message
        $this->info("Poll created successfully with ID: {$poll->id}");
    }
}
