<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Assignment;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama siswa
     */
    public function index()
    {
        $user = Auth::user();

        // ===============================
        // SUMMARY DATA
        // ===============================
        $avgGrade = Grade::where('user_id', $user->id)->avg('score') ?? 0;

        $pendingAssignments = Assignment::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->count();

        // Jadwal hari ini (optional kalau relasi ada)
        $today = Carbon::now()->format('l'); // Monday, Tuesday...
        $todaysSchedule = $user->schedules()
            ->where('day', $today)
            ->orderBy('start_time')
            ->with('subject')
            ->get();

        // ===============================
        // 🔥 HEATMAP DATA (GitHub style)
        // ===============================
        $heatmap = Grade::where('user_id', $user->id)
    ->selectRaw('DATE(created_at) as day, AVG(score) as avg_score')
    ->groupBy('day')
    ->pluck('avg_score', 'day')
    ->toArray();

        return view('dashboard', compact(
            'avgGrade',
            'pendingAssignments',
            'todaysSchedule',
            'heatmap'
        ));
    }
}