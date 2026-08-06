<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Comment;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Document::class);

        $query = Document::with('user')
            ->where('status', '!=', DocumentStatus::DRAFT->value)
            ->search($request->search)
            ->filterStatus($request->status)
            ->filterType($request->type)
            ->submittedBetween($request->submitted_from, $request->submitted_to);

        $documents = $query->latest()->paginate(10)->withQueryString();
        
        $statuses = DocumentStatus::cases();
        $types = DocumentType::cases();

        return view('admin.documents.index', compact('documents', 'statuses', 'types'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $this->authorize('view', $document);

        $document->load([
            'user',
            'comments' => fn($q) => $q->whereNull('parent_id'),
            'comments.user',
            'comments.replies.user',
            'comments.replies.parent.user',
            'statusHistories' => fn($q) => $q->oldest('created_at'),
            'statusHistories.user'
        ]);
        
        $replyToComment = null;
        if (request()->has('reply_to')) {
            $replyToComment = Comment::with('user')->find(request('reply_to'));
        }
        
        auth()->user()->markDocumentNotificationsAsRead($document);
        
        return view('admin.documents.show', compact('document', 'replyToComment'));
    }
}
