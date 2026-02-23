<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('subject')
            ->where('user_id', Auth::id())
            ->latest('date')
            ->get();

        $subjects = Subject::where('user_id', Auth::id())->get();

        return view('attendances.index', compact('attendances', 'subjects'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        Attendance::create([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return back()->with('success', 'Kehadiran ditambahkan');
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        abort_if($attendance->user_id !== Auth::id(), 403);

        $attendance->update($request->validated());

        return back()->with('success', 'Kehadiran diperbarui');
    }

    public function destroy(Attendance $attendance)
    {
        abort_if($attendance->user_id !== Auth::id(), 403);

        $attendance->delete();

        return back()->with('success', 'Kehadiran dihapus');
    }
}