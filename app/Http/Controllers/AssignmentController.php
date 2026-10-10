<?php

// File: app/Http/Controllers/AssignmentController.php
// Controller untuk mengelola tugas (assignments) pengguna

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Services\GamificationService;

class AssignmentController extends Controller
{
    /**
     * Menampilkan daftar semua tugas milik pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua tugas milik user yang sedang login, beserta relasi subject-nya
        // Diurutkan dari yang terbaru (latest)
        $assignments = Assignment::with('subject')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        // Ambil semua mata pelajaran milik user untuk keperluan form (dropdown)
        $subjects = Subject::where('user_id', Auth::id())->get();

        return view('assignments.index', compact('assignments','subjects'));
    }

    /**
     * Menyimpan tugas baru ke database.
     *
     * @param  \App\Http\Requests\StoreAssignmentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAssignmentRequest $request)
    {
        // Buat assignment baru
        $assignment = Assignment::create([
            'user_id' => Auth::id(), // Tambahkan user_id secara manual
            ...$request->validated(), // Sebar (spread) data yang sudah divalidasi
            'xp_awarded_for_completion' => false, // Default false, belum mendapat XP
        ]);

        // Jika langsung dibuat dengan status Completed, kasih XP (hanya sekali)
        if ($request->status == 'Completed') {
            $gamification = new GamificationService(Auth::user());
            $gamification->completeTask(); // Tambah XP +8
            
            // Tandai sudah dapat XP
            $assignment->xp_awarded_for_completion = true;
            $assignment->save();
            
            return back()->with('success', 'Tugas ditambahkan dan selesai! +8 XP 🎉');
        }

        return back()->with('success', 'Tugas ditambahkan');
    }

    /**
     * Memperbarui tugas yang sudah ada.
     *
     * @param  \App\Http\Requests\UpdateAssignmentRequest  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        // Pastikan user hanya bisa mengupdate tugas miliknya sendiri
        $this->authorizeAssignment($assignment);

        // Simpan status lama dan status XP sebelum update
        $oldStatus = $assignment->status;
        $oldXpAwarded = $assignment->xp_awarded_for_completion;
        
        // Update assignment dengan data baru yang sudah divalidasi
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

    /**
     * Menghapus tugas dari database.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Assignment $assignment)
    {
        // Pastikan user hanya bisa menghapus tugas miliknya sendiri
        $this->authorizeAssignment($assignment);

        $assignment->delete();

        return back()->with('success', 'Tugas dihapus');
    }

    /**
     * Memeriksa apakah tugas milik user yang sedang login.
     * Jika bukan, tampilkan error 403.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return void
     */
    private function authorizeAssignment($assignment)
    {
        if ($assignment->user_id !== Auth::id()) {
            abort(403);
        }
    }
}