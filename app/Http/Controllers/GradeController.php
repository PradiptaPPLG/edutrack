<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;

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
            'kkm' // Kirim kkm ke view
        ));
    }
    
    public function store(StoreGradeRequest $request)
    {
        Grade::create([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return back()->with('success','Nilai ditambahkan');
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        abort_if($grade->user_id !== Auth::id(), 403);

        $grade->update($request->validated());

        return back()->with('success','Nilai diperbarui');
    }

    public function destroy(Grade $grade)
    {
        abort_if($grade->user_id !== Auth::id(), 403);

        $grade->delete();
        return back()->with('success','Nilai dihapus');
    }
}