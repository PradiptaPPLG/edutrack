<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => \App\Models\Subject::factory(),
            'user_id' => \App\Models\User::factory(),
            'activity_name' => $this->faker->randomElement(['Tugas 1', 'Tugas 2', 'Kuis', 'UTS', 'UAS']),
            'score' => $this->faker->numberBetween(60, 100),
        ];
    }
}
