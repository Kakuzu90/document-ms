<?php

namespace App\Http\Controllers\Teacher;

use App\Events\DocumentSubmitted;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type'  => ['required', 'in:lesson_plan,form,report,other'],
            'file'  => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'], // 10MB
        ]);

        $path = $request->file('file')->store('documents/' . $request->user()->id);

        $document = $request->user()->documents()->create([
            'title'     => $request->title,
            'type'      => $request->type,
            'file_path' => $path,
            'status'    => 'submitted',
        ]);

        DocumentSubmitted::dispatch($document);

        return redirect()->route('teacher.dashboard')->with('status', 'Document submitted successfully!');
    }
}
