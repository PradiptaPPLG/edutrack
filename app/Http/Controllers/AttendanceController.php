<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar absensi.
     */
    public function index()
    {
        $attendances = Auth::user()->attendances()->with('subject')->latest('date')->get();
        return view('attendances.index', compact('attendances'));
    }

    /**
     * Menampilkan formulir untuk mencatat absensi baru.
     */
    public function create()
    {
        $subjects = Auth::user()->subjects;
        return view('attendances.create', compact('subjects'));
    }

    /**
     * Menyimpan data absensi baru ke dalam penyimpanan.
     */
    public function store(StoreAttendanceRequest $request)
    {
        $request->user()->attendances()->create($request->validated());

        return redirect()->route('attendances.index')->with('success', 'Kehadiran berhasil dicatat.');
    }

    /**
     * Menampilkan formulir untuk mengedit absensi.
     */
    public function edit(Attendance $attendance)
    {
        if ($attendance->user_id !== Auth::id()) abort(403);
        $subjects = Auth::user()->subjects;
        return view('attendances.edit', compact('attendance', 'subjects'));
    }

    /**
     * Memperbarui data absensi yang ditentukan dalam penyimpanan.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        if ($attendance->user_id !== Auth::id()) abort(403);

        $attendance->update($request->validated());

        return redirect()->route('attendances.index')->with('success', 'Kehadiran berhasil diperbarui.');
    }

    /**
     * Menghapus data absensi yang ditentukan dari penyimpanan.
     */
    public function destroy(Attendance $attendance)
    {
        if ($attendance->user_id !== Auth::id()) abort(403);
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Kehadiran berhasil dihapus.');
    }
}
