<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;

class StreakService
{
    public static function update(User $user)
    {
        $today = Carbon::today();
        
        // Pastikan streak tidak null
        if (is_null($user->streak)) {
            $user->streak = 0;
        }
        
        $last = $user->last_login_date ? Carbon::parse($user->last_login_date) : null;

        // Jika sudah login hari ini, jangan update
        if ($last && $last->isSameDay($today)) {
            return $user->streak;
        }

        // Jika login kemarin, tambah streak
        if ($last && $last->isYesterday()) {
            $user->streak += 1;
        } 
        // Jika login lebih dari kemarin atau pertama kali
        else {
            $user->streak = 1;
        }

        $user->last_login_date = $today;
        $user->save();
        
        return $user->streak;
    }

    public static function getStreakLevel($days)
    {
        $days = (int) $days; // Pastikan integer
        
        if ($days >= 365) return 6; // Cosmic Void
        if ($days >= 180) return 5; // Solar Flare
        if ($days >= 90) return 4;  // Blue Inferno
        if ($days >= 30) return 3;  // Blazing Torch
        if ($days >= 14) return 2;  // Steady Burn
        if ($days >= 3) return 1;   // Spark Starter
        return 0;                    // No streak
    }
    
    public static function getStreakInfo($days)
    {
        $level = self::getStreakLevel($days);
        
        $names = [
            0 => 'No Streak',
            1 => 'Spark Starter',
            2 => 'Steady Burn',
            3 => 'Blazing Torch',
            4 => 'Blue Inferno',
            5 => 'Solar Flare',
            6 => 'Cosmic Void'
        ];
        
        $icons = [
            0 => null,
            1 => 'api1.png',
            2 => 'api2.png',
            3 => 'api3.png',
            4 => 'api4.png',
            5 => 'api5.png',
            6 => 'api6.png'
        ];
        
        return [
            'level' => $level,
            'name' => $names[$level] ?? 'Unknown',
            'icon' => $icons[$level] ? asset('images/streak/' . $icons[$level]) : null,
            'days' => $days,
            'next_level' => self::getNextLevelRequirement($days)
        ];
    }
    
    public static function getNextLevelRequirement($days)
    {
        if ($days < 3) return 3;
        if ($days < 14) return 14;
        if ($days < 30) return 30;
        if ($days < 90) return 90;
        if ($days < 180) return 180;
        if ($days < 365) return 365;
        return null; // Max level
    }
}