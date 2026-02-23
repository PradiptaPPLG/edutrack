<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;

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
        Note::create([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return back()->with('success', 'Catatan ditambahkan');
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);

        $note->update($request->validated());

        return back()->with('success', 'Catatan diperbarui');
    }

    public function destroy(Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);

        $note->delete();

        return back()->with('success', 'Catatan dihapus');
    }
}