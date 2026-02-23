<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('subject')
            ->where('user_id', Auth::id())
            ->orderBy('day')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        $subjects = Subject::where('user_id', Auth::id())->get();

        return view('schedules.index', compact('schedules','subjects'));
    }

    public function store(StoreScheduleRequest $request)
    {
        Schedule::create([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return back()->with('success','Jadwal ditambahkan');
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        abort_if($schedule->user_id !== Auth::id(), 403);

        $schedule->update($request->validated());

        return back()->with('success','Jadwal diperbarui');
    }

    public function destroy(Schedule $schedule)
    {
        abort_if($schedule->user_id !== Auth::id(), 403);
        $schedule->delete();

        return back()->with('success','Jadwal dihapus');
    }
}