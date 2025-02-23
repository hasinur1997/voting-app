<?php
namespace Database\Factories;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollOptionFactory extends Factory
{
    protected $model = PollOption::class;

    public function definition()
    {
        return [
            'poll_id' => Poll::factory(),
            'option_text' => $this->faker->word(),
            'votes' => 0, 
        ];
    }
}
