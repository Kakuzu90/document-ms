<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateTeacherRequest;
use App\Actions\GetFilteredTeachers;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index(Request $request, GetFilteredTeachers $action)
    {
        $this->authorize('viewAny', User::class);

        $teachers = $action->handle($request->only(['search', 'status', 'joined_date']));

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Display the specified teacher's profile and documents.
     */
    public function show(Request $request, User $teacher)
    {
        $this->authorize('view', $teacher);

        // Load documents with pagination and filters
        $documents = $teacher->documents()
            ->search($request->search)
            ->filterStatus($request->status)
            ->filterType($request->type)
            ->submittedBetween($request->submitted_from, $request->submitted_to)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $statuses = \App\Enums\DocumentStatus::cases();
        $types = \App\Enums\DocumentType::cases();

        return view('admin.teachers.show', compact('teacher', 'documents', 'statuses', 'types'));
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
