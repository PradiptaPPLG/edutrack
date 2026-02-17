<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar jadwal.
     */
    public function index()
    {
        $schedules = Auth::user()->schedules()->with('subject')->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")->orderBy('start_time')->get();
        return view('schedules.index', compact('schedules'));
    }

    /**
     * Menampilkan formulir untuk membuat jadwal baru.
     */
    public function create()
    {
        $subjects = Auth::user()->subjects;
        return view('schedules.create', compact('subjects'));
    }

    /**
     * Menyimpan jadwal baru ke dalam penyimpanan.
     */
    public function store(StoreScheduleRequest $request)
    {
        $request->user()->schedules()->create($request->validated());

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit jadwal.
     */
    public function edit(Schedule $schedule)
    {
        if ($schedule->user_id !== Auth::id()) abort(403);
        $subjects = Auth::user()->subjects;
        return view('schedules.edit', compact('schedule', 'subjects'));
    }

    /**
     * Memperbarui jadwal yang ditentukan dalam penyimpanan.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        if ($schedule->user_id !== Auth::id()) abort(403);

        $schedule->update($request->validated());

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal yang ditentukan dari penyimpanan.
     */
    public function destroy(Schedule $schedule)
    {
        if ($schedule->user_id !== Auth::id()) abort(403);
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
