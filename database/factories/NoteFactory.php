<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'subject_id' => $this->faker->optional(0.7)->randomElement(\App\Models\Subject::pluck('id')->toArray()) ?? \App\Models\Subject::factory(),
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'category' => $this->faker->randomElement(['General', 'Exam Prep', 'Homework', 'Project']),
            'status' => $this->faker->randomElement(['In Progress', 'Completed']),
            'is_favorite' => $this->faker->boolean(20),
        ];
    }
}
