<?php

// File: app/Http/Controllers/AttendanceController.php
// Controller untuk mengelola data kehadiran (attendance) pengguna

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar semua kehadiran milik pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua data kehadiran milik user yang sedang login, beserta relasi subject-nya
        // Diurutkan berdasarkan tanggal terbaru (latest)
        $attendances = Attendance::with('subject')
            ->where('user_id', Auth::id())
            ->latest('date')
            ->get();

        // Ambil semua mata pelajaran milik user untuk keperluan dropdown di form
        $subjects = Subject::where('user_id', Auth::id())->get();

        return view('attendances.index', compact('attendances', 'subjects'));
    }

    /**
     * Menyimpan data kehadiran baru ke database.
     *
     * @param  \App\Http\Requests\StoreAttendanceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAttendanceRequest $request)
    {
        // Buat record kehadiran baru
        Attendance::create([
            'user_id' => Auth::id(), // Tambahkan user_id secara manual
            ...$request->validated() // Sebar (spread) data yang sudah divalidasi
        ]);

        return back()->with('success', 'Kehadiran ditambahkan');
    }

    /**
     * Memperbarui data kehadiran yang sudah ada.
     *
     * @param  \App\Http\Requests\UpdateAttendanceRequest  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        // Cek kepemilikan: jika bukan milik user, tampilkan error 403
        abort_if($attendance->user_id !== Auth::id(), 403);

        // Update dengan data yang sudah divalidasi
        $attendance->update($request->validated());

        return back()->with('success', 'Kehadiran diperbarui');
    }

    /**
     * Menghapus data kehadiran dari database.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Attendance $attendance)
    {
        // Cek kepemilikan: jika bukan milik user, tampilkan error 403
        abort_if($attendance->user_id !== Auth::id(), 403);

        $attendance->delete();

        return back()->with('success', 'Kehadiran dihapus');
    }
}