<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Events\DocumentSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Document::class);

        return view('teacher.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        $this->authorize('create', Document::class);

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
