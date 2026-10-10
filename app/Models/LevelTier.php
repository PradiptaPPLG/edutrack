<?php

namespace App\Models;

class LevelTier
{
    public static function getAllTiers()
    {
        return [
            1 => ['name' => 'Beginner Scribbler', 'xp' => 0, 'notes' => 0, 'philosophy' => 'Tahap awal di mana setiap coretan adalah benih ide.'],
            2 => ['name' => 'Beginner Sketcher', 'xp' => 50, 'notes' => 10, 'philosophy' => 'Mulai membentuk pola dari pemikiran yang berserakan.'],
            3 => ['name' => 'Apprentice Trainee', 'xp' => 150, 'notes' => 30, 'philosophy' => 'Belajar mendisiplinkan diri dalam menangkap informasi penting.'],
            4 => ['name' => 'Apprentice Notetaker', 'xp' => 300, 'notes' => 60, 'philosophy' => 'Menjadikan mencatat sebagai bagian dari rutinitas harian.'],
            5 => ['name' => 'Junior Researcher', 'xp' => 500, 'notes' => 100, 'philosophy' => 'Mulai aktif mencari pengetahuan baru untuk diarsipkan.'],
            6 => ['name' => 'Junior Analyst', 'xp' => 800, 'notes' => 160, 'philosophy' => 'Mampu membedah informasi besar menjadi bagian-bagian kecil.'],
            7 => ['name' => 'Pro Documenter', 'xp' => 1200, 'notes' => 240, 'philosophy' => 'Memiliki dokumentasi yang rapi dan mudah untuk dicari kembali.'],
            8 => ['name' => 'Pro Specialist', 'xp' => 1750, 'notes' => 350, 'philosophy' => 'Fokus pada kedalaman materi di bidang yang diminati.'],
            9 => ['name' => 'Senior Scholar', 'xp' => 2500, 'notes' => 500, 'philosophy' => 'Menjadi pelajar teladan yang memiliki gudang referensi pribadi.'],
            10 => ['name' => 'Senior Strategist', 'xp' => 3500, 'notes' => 700, 'philosophy' => 'Menggunakan catatan sebagai basis data untuk mengambil keputusan.'],
            11 => ['name' => 'Expert Curator', 'xp' => 4750, 'notes' => 950, 'philosophy' => 'Mahir memisahkan informasi yang berharga dari kebisingan data.'],
            12 => ['name' => 'Expert Philosopher', 'xp' => 6000, 'notes' => 1200, 'philosophy' => 'Catatan tidak lagi sekadar data, tapi sudah menjadi pemikiran kritis.'],
            13 => ['name' => 'Master Thinker', 'xp' => 7500, 'notes' => 1500, 'philosophy' => 'Memiliki kerangka berpikir yang matang dan terstruktur sempurna.'],
            14 => ['name' => 'Master Archivist', 'xp' => 8500, 'notes' => 1700, 'philosophy' => 'Penjaga perpustakaan ilmu pengetahuan yang sangat luas.'],
            15 => ['name' => 'Grandmaster Sage', 'xp' => 9500, 'notes' => 1900, 'philosophy' => 'Sosok bijaksana yang pikirannya menjadi rujukan utama.'],
            16 => ['name' => 'Legendary Polymath', 'xp' => 10000, 'notes' => 2000, 'philosophy' => 'Penguasa berbagai bidang ilmu dengan warisan catatan abadi.'],
        ];
    }

    public static function getTier($level)
    {
        $tiers = self::getAllTiers();
        return $tiers[$level] ?? $tiers[1];
    }

    public static function calculateLevel($xp, $notes = null) // notes tidak dipakai
{
    $tiers = self::getAllTiers();
    $currentLevel = 1;
    
    foreach ($tiers as $level => $tier) {
        if ($xp >= $tier['xp']) { // HANYA CEK XP
            $currentLevel = $level;
        } else {
            break;
        }
    }
    
    return $currentLevel;
}

    public static function getNextLevelRequirement($currentLevel)
    {
        $tiers = self::getAllTiers();
        $nextLevel = $currentLevel + 1;
        
        if (isset($tiers[$nextLevel])) {
            return [
                'xp' => $tiers[$nextLevel]['xp'],
                'notes' => $tiers[$nextLevel]['notes'],
                'name' => $tiers[$nextLevel]['name']
            ];
        }
        
        return null;
    }

    // ===== TAMBAHKAN METHOD INI UNTUK MENDAPATKAN INFORMASI DENGAN STATUS LOCK =====
    public static function getTierWithLockStatus($level, $userLevel)
    {
        $tiers = self::getAllTiers();
        
        if (!isset($tiers[$level])) {
            return null;
        }
        
        $tier = $tiers[$level];
        $isUnlocked = $userLevel >= $level;
        
        // Jika belum terbuka dan bukan level 1, sembunyikan detailnya
        if (!$isUnlocked && $level > 1) {
            return [
                'level' => $level,
                'name' => '???',
                'xp' => '???',
                'notes' => '???',
                'philosophy' => 'Masih terkunci. Terus belajar untuk membuka tingkatan ini!',
                'is_unlocked' => false,
                'icon' => '🔒',
                'original_name' => $tier['name'],
                'original_xp' => $tier['xp'],
                'original_notes' => $tier['notes']
            ];
        }
        
        // Jika sudah terbuka atau level 1 (selalu terbuka)
        return [
            'level' => $level,
            'name' => $tier['name'],
            'xp' => $tier['xp'],
            'notes' => $tier['notes'],
            'philosophy' => $tier['philosophy'],
            'is_unlocked' => true,
            'icon' => $level == 1 ? '🌟' : '✓',
        ];
    }
    // =============================================================================
}