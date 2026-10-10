<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FixUserStreak extends Command
{
    protected $signature = 'fix:user-streak';
    protected $description = 'Fix null streak values for existing users';

    public function handle()
    {
        $users = User::whereNull('streak')->get();
        
        foreach ($users as $user) {
            $user->streak = 0;
            $user->save();
            $this->info("Fixed streak for user: {$user->email}");
        }
        
        $this->info('All users streak fixed!');
    }
}