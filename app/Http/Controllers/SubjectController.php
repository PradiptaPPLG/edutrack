<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectColor;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('user_id', auth()->id())
            ->where('is_active', 1)
            ->latest()
            ->get();

        $colors = SubjectColor::where('user_id', auth()->id())->get();

        return view('subjects.index', compact('subjects', 'colors'));
    }

    public function store(StoreSubjectRequest $request)
    {
        Subject::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'color_code' => $request->color_code,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran ditambahkan');
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        return back()->with('success', 'Mata pelajaran diperbarui');
    }

    public function destroy(Subject $subject)
    {
        $subject->update(['is_active' => 0]); // SOFT DELETE
        return back()->with('success', 'Mata pelajaran diarsipkan');
    }
}