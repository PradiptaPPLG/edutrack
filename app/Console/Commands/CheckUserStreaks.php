<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\StreakService;
use Illuminate\Console\Command;

class CheckUserStreaks extends Command
{
    protected $signature = 'check:streaks';
    protected $description = 'Check all users streak status';

    public function handle()
    {
        $users = User::all();
        
        $this->table(
            ['ID', 'Name', 'Email', 'Streak', 'Last Login', 'Level', 'Streak Name'],
            $users->map(function ($user) {
                $info = StreakService::getStreakInfo($user->streak ?? 0);
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->streak ?? 0,
                    $user->last_login_date,
                    $info['level'],
                    $info['name']
                ];
            })
        );
        
        return 0;
    }
}