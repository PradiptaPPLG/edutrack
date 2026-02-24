<?php

namespace App\Services;

use App\Models\User;
use App\Models\LevelTier;

class GamificationService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Add XP and recalculate level
     */
    public function addXP($amount, $action = '')
    {
        $this->user->xp += $amount;
        $this->recalculateLevel();
        $this->user->save();
        
        return $this->user;
    }

    /**
     * ============ NOTES ============
     * Membuat catatan baru: +3 XP
     * Menyelesaikan catatan: +5 XP
     */
    
    public function addNote()
    {
        $this->user->total_notes_count += 1;
        $this->addXP(3, 'note_created');
        $this->recalculateLevel();
        $this->user->save();
        
        return $this->user;
    }

    public function completeNote()
    {
        $this->addXP(5, 'note_completed');
        $this->recalculateLevel();
        $this->user->save();
        
        return $this->user;
    }

    /**
     * ============ ASSIGNMENTS ============
     * Menyelesaikan tugas: +8 XP
     */
    
    public function completeTask()
    {
        $this->user->completed_tasks_count += 1;
        $this->addXP(8, 'task_completed');
        $this->recalculateLevel();
        $this->user->save();
        
        return $this->user;
    }

    /**
     * ============ GRADES ============
     * Mendapat nilai ≥ 80: +10 XP
     */
    
    public function addHighScore()
    {
        $this->user->high_scores_count += 1;
        $this->addXP(10, 'high_score');
        $this->recalculateLevel();
        $this->user->save();
        
        return $this->user;
    }

    /**
     * ============ ATTENDANCE ============
     * Hadir: +2 XP
     */
    
    public function addAttendance()
    {
        $this->user->attendance_count += 1;
        $this->addXP(2, 'attendance');
        $this->recalculateLevel();
        $this->user->save();
        
        return $this->user;
    }

    /**
     * ============ LEVEL SYSTEM ============
     */
    
    public function recalculateLevel()
    {
        $newLevel = LevelTier::calculateLevel($this->user->xp);
        
        if ($newLevel != $this->user->level) {
            $this->user->level = $newLevel;
            $this->user->save();
        }
        
        return $this->user;
    }

    public function getCurrentTier()
    {
        return LevelTier::getTier($this->user->level);
    }

    public function getNextLevelRequirement()
    {
        return LevelTier::getNextLevelRequirement($this->user->level);
    }

    public function getProgressToNextLevel()
{
    $currentTier = LevelTier::getTier($this->user->level);
    $nextRequirement = $this->getNextLevelRequirement();
    
    if (!$nextRequirement) {
        return 100; // Max level, return angka saja
    }
    
    $xpNeeded = $nextRequirement['xp'] - $currentTier['xp'];
    $xpEarned = $this->user->xp - $currentTier['xp'];
    
    $xpProgress = $xpNeeded > 0 ? ($xpEarned / $xpNeeded) * 100 : 100;
    
    return min(100, round($xpProgress)); // LANGSUNG RETURN ANGKA, BUKAN ARRAY
}
}