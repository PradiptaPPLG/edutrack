<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Menampilkan daftar nilai.
     */
    public function index()
    {
        $grades = Auth::user()->grades()->with('subject')->latest()->get();
        return view('grades.index', compact('grades'));
    }

    /**
     * Menampilkan formulir untuk mencatat nilai baru.
     */
    public function create()
    {
        $subjects = Auth::user()->subjects;
        return view('grades.create', compact('subjects'));
    }

    /**
     * Menyimpan nilai baru ke dalam penyimpanan.
     */
    public function store(StoreGradeRequest $request)
    {
        $request->user()->grades()->create($request->validated());

        return redirect()->route('grades.index')->with('success', 'Nilai berhasil direkam.');
    }

    /**
     * Menampilkan formulir untuk mengedit nilai.
     */
    public function edit(Grade $grade)
    {
        if ($grade->user_id !== Auth::id()) abort(403);
        $subjects = Auth::user()->subjects;
        return view('grades.edit', compact('grade', 'subjects'));
    }

    /**
     * Memperbarui nilai yang ditentukan dalam penyimpanan.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        if ($grade->user_id !== Auth::id()) abort(403);

        $grade->update($request->validated());

        return redirect()->route('grades.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Menghapus nilai yang ditentukan dari penyimpanan.
     */
    public function destroy(Grade $grade)
    {
        if ($grade->user_id !== Auth::id()) abort(403);
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
