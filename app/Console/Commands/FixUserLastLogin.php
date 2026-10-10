<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class FixUserLastLogin extends Command
{
    protected $signature = 'fix:last-login';
    protected $description = 'Set last_login_date untuk user yang sudah ada';

    public function handle()
    {
        $this->info('Memperbaiki last_login_date untuk user...');

        $users = User::whereNull('last_login_date')->get();
        
        foreach ($users as $user) {
            // Set last_login_date ke created_at agar streak tidak langsung reset
            $user->last_login_date = $user->created_at ? $user->created_at->toDateString() : Carbon::today();
            $user->save();
            
            $this->line("User: {$user->email} - last_login_date set to {$user->last_login_date}");
        }

        $this->info('Selesai! ' . $users->count() . ' user diperbaiki.');
    }
}