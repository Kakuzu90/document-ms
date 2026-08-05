<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Events\DocumentSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Document::class);

        $query = $request->user()->documents();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();
        
        $statuses = DocumentStatus::cases();
        $types = DocumentType::cases();

        return view('teacher.documents.index', compact('documents', 'statuses', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Document::class);

        return view('teacher.documents.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $this->authorize('view', $document);

        $document->load(['comments.user']);

        return view('teacher.documents.show', compact('document'));
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
            'status'    => DocumentStatus::SUBMITTED,
        ]);

        DocumentSubmitted::dispatch($document);

        return redirect()->route('teacher.dashboard')->with('status', 'Document submitted successfully!');
    }
}
