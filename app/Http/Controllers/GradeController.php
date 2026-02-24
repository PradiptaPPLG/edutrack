<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Services\GamificationService; // TAMBAHKAN

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with('subject')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $subjects = Subject::where('user_id', Auth::id())->get();
        
        // Ambil KKM dari user settings
        $kkm = Auth::user()->kkm ?? 75;

        // 📈 Line chart data (progress nilai)
        $lineLabels = $grades->pluck('activity_name');
        $lineScores = $grades->pluck('score');

        // 📊 Average per subject
        $avgData = Grade::selectRaw('subject_id, AVG(score) as avg_score')
            ->where('user_id', Auth::id())
            ->groupBy('subject_id')
            ->with('subject')
            ->get();

        $barLabels = $avgData->map(fn($g)=>$g->subject->name);
        $barScores = $avgData->pluck('avg_score');

        return view('grades.index', compact(
            'grades','subjects',
            'lineLabels','lineScores',
            'barLabels','barScores',
            'kkm'
        ));
    }
    
    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create([
            'user_id' => Auth::id(),
            ...$request->validated(),
            'xp_awarded_for_high_score' => false, // Default false
        ]);

        // CEK: Jika nilai >= 80, kasih XP (hanya sekali)
        if ($grade->score >= 80) {
            $gamification = new GamificationService(Auth::user());
            $gamification->addHighScore();
            
            // Tandai sudah dapat XP
            $grade->xp_awarded_for_high_score = true;
            $grade->save();
            
            return back()->with('success', 'Nilai ditambahkan! +10 XP ⭐ (Nilai Tinggi)');
        }

        return back()->with('success', 'Nilai ditambahkan');
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        abort_if($grade->user_id !== Auth::id(), 403);

        $oldScore = $grade->score;
        $oldXpAwarded = $grade->xp_awarded_for_high_score;
        $oldSubjectId = $grade->subject_id;
        
        $grade->update($request->validated());
        
        // CEK KRITERIA XP:
        // 1. Nilai baru >= 80
        // 2. Belum pernah dapat XP untuk grade ini
        // 3. (Opsional) Nilai lama < 80 (biar fair, tapi tidak wajib)
        if ($grade->score >= 80 && !$oldXpAwarded) {
            
            // Tandai sudah dapat XP
            $grade->xp_awarded_for_high_score = true;
            $grade->save();
            
            // Kasih XP +10
            $gamification = new GamificationService(Auth::user());
            $gamification->addHighScore();
            
            return back()->with('success', 'Nilai diperbarui! +10 XP ⭐ (Nilai Tinggi)');
        }

        return back()->with('success', 'Nilai diperbarui');
    }

    public function destroy(Grade $grade)
    {
        abort_if($grade->user_id !== Auth::id(), 403);

        $grade->delete();
        return back()->with('success', 'Nilai dihapus');
    }
}