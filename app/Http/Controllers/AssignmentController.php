<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Services\GamificationService;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with('subject')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        $subjects = Subject::where('user_id', Auth::id())->get();

        return view('assignments.index', compact('assignments','subjects'));
    }

    public function store(StoreAssignmentRequest $request)
    {
        $assignment = Assignment::create([
            'user_id' => Auth::id(),
            ...$request->validated(),
            'xp_awarded_for_completion' => false, // Default false
        ]);

        // Jika langsung dibuat dengan status Completed, kasih XP (hanya sekali)
        if ($request->status == 'Completed') {
            $gamification = new GamificationService(Auth::user());
            $gamification->completeTask();
            
            // Tandai sudah dapat XP
            $assignment->xp_awarded_for_completion = true;
            $assignment->save();
            
            return back()->with('success', 'Tugas ditambahkan dan selesai! +8 XP 🎉');
        }

        return back()->with('success', 'Tugas ditambahkan');
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $oldStatus = $assignment->status;
        $oldXpAwarded = $assignment->xp_awarded_for_completion;
        
        $assignment->update($request->validated());
        
        // CEK: Jika status berubah dari Pending ke Completed 
        // DAN belum pernah dapat XP untuk completed sebelumnya
        if ($oldStatus == 'Pending' && $assignment->status == 'Completed' && !$oldXpAwarded) {
            
            // Tandai bahwa assignment ini sudah pernah memberikan XP completed
            $assignment->xp_awarded_for_completion = true;
            $assignment->save();
            
            // Kasih XP +8 untuk menyelesaikan tugas (HANYA SEKALI)
            $gamification = new GamificationService(Auth::user());
            $gamification->completeTask();
            
            return back()->with('success', 'Selamat! Tugas selesai! +8 XP 🎉');
        }

        return back()->with('success', 'Tugas diperbarui');
    }

    public function destroy(Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $assignment->delete();

        return back()->with('success', 'Tugas dihapus');
    }

    private function authorizeAssignment($assignment)
    {
        if ($assignment->user_id !== Auth::id()) {
            abort(403);
        }
    }
}