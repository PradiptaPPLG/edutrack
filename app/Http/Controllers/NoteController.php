<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\GamificationService;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('subject')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $subjects = Subject::where('user_id', Auth::id())->get();

        return view('notes.index', compact('notes', 'subjects'));
    }

    public function store(StoreNoteRequest $request)
    {
        $note = Note::create([
            'user_id' => Auth::id(),
            ...$request->validated(),
            'xp_awarded_for_completion' => false, // Default false
        ]);

        // Kasih XP untuk membuat catatan baru (+3 XP) - HANYA SEKALI
        $gamification = new GamificationService(Auth::user());
        $gamification->addNote();

        return back()->with('success', 'Catatan ditambahkan! +3 XP 📝');
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);

        $oldStatus = $note->status;
        $oldXpAwarded = $note->xp_awarded_for_completion;
        
        $note->update($request->validated());
        
        // CEK: Jika status berubah dari "In Progress" ke "Completed" 
        // DAN belum pernah dapat XP untuk completed sebelumnya
        if ($oldStatus == 'In Progress' && $note->status == 'Completed' && !$oldXpAwarded) {
            
            // Tandai bahwa note ini sudah pernah memberikan XP completed
            $note->xp_awarded_for_completion = true;
            $note->save();
            
            // Kasih XP +5 untuk menyelesaikan catatan (HANYA SEKALI SEUMUR HIDUP)
            $gamification = new GamificationService(Auth::user());
            $gamification->completeNote(); // Method ini sudah handle +5 XP
            
            return back()->with('success', 'Catatan selesai! +5 XP 🎉');
        }

        // Jika status berubah dari Completed ke In Progress, tidak apa-apa
        // Tapi flag xp_awarded tetap true, jadi kalau completed lagi tidak dapat XP

        return back()->with('success', 'Catatan diperbarui');
    }

    public function destroy(Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);

        $note->delete();

        return back()->with('success', 'Catatan dihapus');
    }
}