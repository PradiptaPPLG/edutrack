<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// MODELS
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ===================== SUMMARY DATA =====================
        // Rata-rata nilai
        $avgGrade = Grade::where('user_id', $user->id)->avg('score') ?? 0;

        // Tugas pending (belum selesai)
        $pendingAssignments = Assignment::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->count();

        // Jadwal hari ini
        $today = Carbon::now()->format('l'); // Monday, Tuesday, etc
        $todaysSchedule = Schedule::where('user_id', $user->id)
            ->where('day', $today)
            ->orderBy('start_time')
            ->with('subject')
            ->get();

        // ===================== RETURN VIEW =====================
        // HANYA kirim variabel yang ADA di view
        return view('dashboard', compact(
            'avgGrade',
            'pendingAssignments',
            'todaysSchedule'
        ));
    }
}