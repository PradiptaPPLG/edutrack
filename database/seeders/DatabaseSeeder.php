<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $user = User::factory()->create([
            'name' => 'Siswa EduTrack',
            'email' => 'siswa@edutrack.com',
            'password' => bcrypt('password'),
        ]);

        // Create Subjects
        $subjects = \App\Models\Subject::factory(6)->create([
            'user_id' => $user->id,
        ]);

        foreach ($subjects as $subject) {
            // Create Assignments for each subject
            \App\Models\Assignment::factory(3)->create([
                'user_id' => $user->id,
                'subject_id' => $subject->id,
            ]);

            // Create Schedules for each subject
            \App\Models\Schedule::factory(2)->create([
                'user_id' => $user->id,
                'subject_id' => $subject->id,
            ]);

            // Create Grades for each subject
            \App\Models\Grade::factory(4)->create([
                'user_id' => $user->id,
                'subject_id' => $subject->id,
            ]);

            // Create Attendances for each subject
            \App\Models\Attendance::factory(5)->create([
                'user_id' => $user->id,
                'subject_id' => $subject->id,
            ]);
        }

        // Create Notes (Start with some linked to subjects)
        \App\Models\Note::factory(5)->create([
            'user_id' => $user->id,
            'subject_id' => $subjects->random()->id,
        ]);

        // Create General Notes (No Subject)
        \App\Models\Note::factory(3)->create([
            'user_id' => $user->id,
            'subject_id' => null,
            'category' => 'General',
        ]);
    }
}
