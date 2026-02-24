<?php

namespace App\Http\Controllers;

use App\Models\LevelTier;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $allTiers = LevelTier::getAllTiers();
        
        // Ubah semua tier dengan status lock/unlock
        $tiers = [];
        foreach (array_keys($allTiers) as $level) {
            $tiers[$level] = LevelTier::getTierWithLockStatus($level, $user->level);
        }
        
        $currentTier = LevelTier::getTierWithLockStatus($user->level, $user->level);
        $nextTier = LevelTier::getNextLevelRequirement($user->level);
        
        // Hitung progress
        $gamification = new \App\Services\GamificationService($user);
        $progress = $gamification->getProgressToNextLevel(); // SEKARANG LANGSUNG ANGKA
        
        // Statistik
        $stats = [
            'total_notes' => $user->total_notes_count,
            'completed_tasks' => $user->completed_tasks_count,
            'high_scores' => $user->high_scores_count,
            'attendance' => $user->attendance_count,
            'xp' => $user->xp,
            'level' => $user->level
        ];
        
        return view('account.achievements', compact('user', 'tiers', 'currentTier', 'nextTier', 'progress', 'stats'));
    }
}