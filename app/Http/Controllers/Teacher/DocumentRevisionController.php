<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviseDocumentRequest;
use App\Actions\ReviseDocument;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentRevisionController extends Controller
{
    public function show(Document $document)
    {
        $this->authorize('revise', $document);

        if ($document->status === DocumentStatus::UNDER_REVIEW) {
            return redirect()->route('teacher.documents.show', $document)->with('error', 'This document is currently under review and cannot be changed.');
        }

        if ($document->status === DocumentStatus::REVIEWED) {
            return redirect()->route('teacher.documents.show', $document)->with('error', 'This document has been reviewed and cannot be changed.');
        }

        if ($document->status === DocumentStatus::DRAFT) {
            return redirect()->route('teacher.documents.show', $document)->with('error', 'Draft documents use the standard upload form.');
        }

        $document->load(['comments.user']);

        return view('teacher.documents.revise', compact('document'));
    }

    public function store(ReviseDocumentRequest $request, Document $document, ReviseDocument $action)
    {
        $this->authorize('revise', $document);

        if (!in_array($document->status, [DocumentStatus::SUBMITTED, DocumentStatus::NEEDS_REVISION])) {
            abort(403, 'Invalid document status for revision.');
        }

        $action->handle(
            $document,
            $request->user(),
            $request->file('file'),
            $request->note
        );

        return redirect()->route('teacher.documents.index')->with('status', 'Your file has been updated.');
    }
}
