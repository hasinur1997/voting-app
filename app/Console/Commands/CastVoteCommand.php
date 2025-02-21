<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VoteService;
use App\Models\PollOption;

class CastVoteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:cast {poll_option_id : The ID of the poll option to vote for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cast a vote for a poll option';

    /**
     * The VoteService instance.
     *
     * @var VoteService
     */
    protected VoteService $voteService;

    /**
     * CastVoteCommand constructor.
     *
     * @param VoteService $voteService
     */
    public function __construct(VoteService $voteService)
    {
        parent::__construct();
        $this->voteService = $voteService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Get the poll option ID from the command argument
        $pollOptionId = $this->argument('poll_option_id');
        // Find the poll option or return 404 if not found
        $pollOption = PollOption::findOrFail($pollOptionId);
        $userIp = request()->ip() ?? '127.0.0.1'; // Default IP for CLI execution

        try {
            // Attempt to cast a vote using the VoteService
            $this->voteService->castVote($pollOption, $userIp);

            $this->info("Vote successfully cast for Poll Option ID: $pollOptionId");

        } catch (\Exception $e) {
            $this->error("Failed to cast vote: " . $e->getMessage());
        }
    }
}
