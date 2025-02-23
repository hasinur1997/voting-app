<?php
namespace Database\Factories;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollFactory extends Factory
{
    protected $model = Poll::class;

    public function definition()
    {
        return [
            'question' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
        ];
    }
}
