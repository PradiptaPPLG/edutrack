<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Cek dulu apakah tabel dan kolom sudah ada sebelum mengakses
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'streak') && Schema::hasColumn('users', 'last_login_date')) {
            // Update hanya jika di web environment
            if (!$this->app->runningInConsole()) {
                try {
                    // Update streak null jadi 0
                    \App\Models\User::whereNull('streak')->update(['streak' => 0]);
                    
                    // Update last_login_date null jadi created_at
                    \App\Models\User::whereNull('last_login_date')
                        ->whereNotNull('created_at')
                        ->update(['last_login_date' => \DB::raw('DATE(created_at)')]);
                } catch (\Exception $e) {
                    // Abaikan error
                }
            }
        }
    }
}