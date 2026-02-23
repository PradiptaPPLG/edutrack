<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;

class AssignmentController extends Controller
{
    public function index()
{
    $assignments = Assignment::with('subject')
    ->where('user_id', Auth::id())
    ->latest()
    ->get();

    $subjects = Subject::where('user_id', Auth::id())->get();

    return view('assignments.index', compact('assignments','subjects'));
}

    public function store(StoreAssignmentRequest $request)
    {
        Assignment::create([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return back()->with('success','Tugas ditambahkan');
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $assignment->update($request->validated());

        return back()->with('success','Tugas diperbarui');
    }

    public function destroy(Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $assignment->delete();

        return back()->with('success','Tugas dihapus');
    }

    private function authorizeAssignment($assignment)
    {
        if ($assignment->user_id !== Auth::id()) {
            abort(403);
        }
    }
}