<?php
namespace Tests\Feature;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VotingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_vote_for_an_option_in_a_poll()
    {
        // Create a poll
        $poll = Poll::factory()->create();

        // Create poll options for the poll
        $option1 = PollOption::factory()->create(['poll_id' => $poll->id]);
        $option2 = PollOption::factory()->create(['poll_id' => $poll->id]);

        // Simulate a user voting for option1
        $response = $this->postJson(route('vote.cast', $option1->id), [
            'user_ip' => '127.0.0.1', // Use the correct local IP
        ]);

        // Assert the vote is stored in the database
        $this->assertDatabaseHas('votes', [
            'poll_id' => $poll->id,
            'poll_option_id' => $option1->id,
            'user_ip' => '127.0.0.1', // Match the IP address
        ]);

        // Assert the vote count for option1 is incremented
        $option1->refresh();
        $this->assertEquals(1, $option1->votes);

        // Assert the response status is 200 (successful)
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_cannot_vote_more_than_once()
    {
        // Create a poll
        $poll = Poll::factory()->create();

        // Create poll options for the poll
        $option1 = PollOption::factory()->create(['poll_id' => $poll->id]);

        // Simulate a user voting for option1
        $this->postJson(route('vote.cast', $option1->id), [
            'user_ip' => '127.0.0.1',
        ]);

        $response = $this->postJson(route('vote.cast', $option1->id), [
            'user_ip' => '127.0.0.1',
        ]);


        $response->assertStatus(403);
        $response->assertJson(['message' => 'You have already voted!']);
    }
}
