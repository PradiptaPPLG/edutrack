<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Menampilkan daftar tugas.
     */
    public function index()
    {
        $assignments = Auth::user()->assignments()->with('subject')->orderBy('due_date')->get();
        return view('assignments.index', compact('assignments'));
    }

    /**
     * Menampilkan formulir untuk membuat tugas baru.
     */
    public function create()
    {
        $subjects = Auth::user()->subjects;
        return view('assignments.create', compact('subjects'));
    }

    /**
     * Menyimpan tugas baru ke dalam penyimpanan.
     */
    public function store(StoreAssignmentRequest $request)
    {
        $request->user()->assignments()->create($request->validated());

        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit tugas.
     */
    public function edit(Assignment $assignment)
    {
        if ($assignment->user_id !== Auth::id()) abort(403);
        $subjects = Auth::user()->subjects;
        return view('assignments.edit', compact('assignment', 'subjects'));
    }

    /**
     * Memperbarui tugas yang ditentukan dalam penyimpanan.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        if ($assignment->user_id !== Auth::id()) abort(403);

        $assignment->update($request->validated());

        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Menghapus tugas yang ditentukan dari penyimpanan.
     */
    public function destroy(Assignment $assignment)
    {
        if ($assignment->user_id !== Auth::id()) abort(403);
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
