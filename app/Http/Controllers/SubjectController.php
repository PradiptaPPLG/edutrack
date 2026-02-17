<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Menampilkan daftar mata pelajaran.
     */
    public function index()
    {
        $subjects = Auth::user()->subjects()->latest()->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Menampilkan formulir untuk membuat mata pelajaran baru.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Menyimpan mata pelajaran baru ke dalam penyimpanan.
     */
    public function store(StoreSubjectRequest $request)
    {
        $request->user()->subjects()->create($request->validated());

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit mata pelajaran.
     */
    public function edit(Subject $subject)
    {
        if ($subject->user_id !== Auth::id()) abort(403);
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Memperbarui mata pelajaran yang ditentukan dalam penyimpanan.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        if ($subject->user_id !== Auth::id()) abort(403);

        $subject->update($request->validated());

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus mata pelajaran yang ditentukan dari penyimpanan.
     */
    public function destroy(Subject $subject)
    {
        if ($subject->user_id !== Auth::id()) abort(403);
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
