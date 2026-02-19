<?php

namespace Database\Seeders;

use App\Models\{
    Assignment,
    Grade,
    Note,
    Schedule,
    Subject,
    User,
    Attendance
};
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
        $user = User::factory()->create([
            'name' => 'Siswa EduTrack',
            'email' => 'siswa@edutrack.com',
            'password' => bcrypt('password'),
        ]);

        // $subjects = Subject::factory(6)->create([
        //     'user_id' => $user->id,
        // ]);

        // foreach ($subjects as $subject) {
        //     Assignment::factory(3)->create([
        //         'user_id' => $user->id,
        //         'subject_id' => $subject->id,
        //     ]);

        //     Schedule::factory(2)->create([
        //         'user_id' => $user->id,
        //         'subject_id' => $subject->id,
        //     ]);

        //     Grade::factory(4)->create([
        //         'user_id' => $user->id,
        //         'subject_id' => $subject->id,
        //     ]);

        //     Attendance::factory(5)->create([
        //         'user_id' => $user->id,
        //         'subject_id' => $subject->id,
        //     ]);
        // }

        // Note::factory(5)->create([
        //     'user_id' => $user->id,
        //     'subject_id' => $subjects->random()->id,
        // ]);

        // Note::factory(3)->create([
        //     'user_id' => $user->id,
        //     'subject_id' => null,
        //     'category' => 'General',
        // ]);
    }
}
