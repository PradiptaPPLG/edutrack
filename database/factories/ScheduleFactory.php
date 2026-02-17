<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->time('H:i');
        return [
            'subject_id' => \App\Models\Subject::factory(),
            'user_id' => \App\Models\User::factory(),
            'day' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'start_time' => $startTime,
            'end_time' => date('H:i', strtotime($startTime) + 5400), // +90 minutes
        ];
    }
}
