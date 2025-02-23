<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\PollService;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Polls data in an array format
        $polls = [
            [
                'question' => 'Favorite Programming Language',
                'options' => [
                    'PHP',
                    'JavaScript',
                    'Python',
                    'Ruby',
                ],
            ],
            [
                'question' => 'Preferred OS',
                'options' => [
                    'Windows',
                    'macOS',
                    'Linux',
                    'Others',
                ],
            ],
            [
                'question' => 'Best Web Framework',
                'options' => [
                    'Laravel',
                    'Django',
                    'Ruby on Rails',
                    'Express',
                ],
            ],
            [
                'question' => 'Favorite Browser',
                'options' => [
                    'Google Chrome',
                    'Firefox',
                    'Safari',
                    'Microsoft Edge',
                ],
            ],
        ];

        $pollService = new PollService;

        foreach ($polls as $pollData) {
            $pollService->createPoll($pollData['question'], $pollData['options']);
        }
    }
}
