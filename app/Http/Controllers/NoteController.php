<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Menampilkan daftar catatan.
     */
    public function index()
    {
        $notes = Auth::user()->notes()->latest()->get();
        return view('notes.index', compact('notes'));
    }

    /**
     * Menampilkan formulir untuk membuat catatan baru.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Menyimpan catatan baru ke dalam penyimpanan.
     */
    public function store(StoreNoteRequest $request)
    {
        $request->user()->notes()->create($request->validated());

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dibuat.');
    }

    /**
     * Menampilkan catatan spesifik.
     */
    public function show(Note $note)
    {
        // Policy check or manual check
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        return view('notes.show', compact('note'));
    }

    /**
     * Menampilkan formulir untuk mengedit catatan.
     */
    public function edit(Note $note)
    {
        // Policy check or manual check
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        return view('notes.edit', compact('note'));
    }

    /**
     * Memperbarui catatan yang ditentukan dalam penyimpanan.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->update($request->validated());

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diperbarui.');
    }

    /**
     * Menghapus catatan yang ditentukan dari penyimpanan.
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus.');
    }
}
