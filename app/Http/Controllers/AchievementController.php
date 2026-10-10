<?php

// File: app/Http/Controllers/AchievementController.php
// Controller untuk menampilkan halaman pencapaian (achievements) dan level pengguna

namespace App\Http\Controllers;

use App\Models\LevelTier;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    /**
     * Menampilkan halaman achievements (pencapaian dan level).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();
        
        // Ambil semua tier level dari model LevelTier
        // getAllTiers() kemungkinan mengembalikan array berisi semua level beserta kebutuhannya
        $allTiers = LevelTier::getAllTiers();
        
        // Ubah semua tier dengan status lock/unlock berdasarkan level user saat ini
        $tiers = [];
        // Loop melalui setiap level (array_keys mengambil semua key/nama level)
        foreach (array_keys($allTiers) as $level) {
            // getTierWithLockStatus akan mengembalikan data tier beserta status terkunci atau tidak
            // berdasarkan level user dan level tier yang sedang diproses
            $tiers[$level] = LevelTier::getTierWithLockStatus($level, $user->level);
        }
        
        // Ambil data tier untuk level user saat ini
        $currentTier = LevelTier::getTierWithLockStatus($user->level, $user->level);
        
        // Ambil kebutuhan XP untuk level berikutnya
        $nextTier = LevelTier::getNextLevelRequirement($user->level);
        
        // Hitung progress ke level berikutnya menggunakan GamificationService
        $gamification = new \App\Services\GamificationService($user);
        $progress = $gamification->getProgressToNextLevel(); // Mengembalikan angka persentase (0-100)
        
        // Kumpulkan statistik pengguna untuk ditampilkan
        $stats = [
            'total_notes' => $user->total_notes_count,       // Total catatan yang dibuat
            'completed_tasks' => $user->completed_tasks_count, // Total tugas yang selesai
            'high_scores' => $user->high_scores_count,       // Total nilai tinggi/quiz
            'attendance' => $user->attendance_count,         // Total kehadiran
            'xp' => $user->xp,                                // Total XP yang dimiliki
            'level' => $user->level                           // Level saat ini
        ];
        
        // Tampilkan view achievements dengan semua data yang diperlukan
        return view('account.achievements', compact('user', 'tiers', 'currentTier', 'nextTier', 'progress', 'stats'));
    }
}