<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateTeacherRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $teachers = User::where('role', 'teacher')
            ->withCount('documents')
            ->latest()
            ->paginate(20);

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Display the specified teacher's profile and documents.
     */
    public function show(User $teacher)
    {
        $this->authorize('view', $teacher);

        // Load 10 most recent documents
        $documents = $teacher->documents()->latest()->take(10)->get();

        return view('admin.teachers.show', compact('teacher', 'documents'));
    }

    /**
     * Show the form for editing the teacher.
     */
    public function edit(User $teacher)
    {
        $this->authorize('update', $teacher);

        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the teacher in storage.
     */
    public function update(UpdateTeacherRequest $request, User $teacher)
    {
        $this->authorize('update', $teacher);

        $teacher->update($request->validated());

        return redirect()->route('admin.teachers.show', $teacher)->with('status', 'Teacher profile updated successfully.');
    }
}
