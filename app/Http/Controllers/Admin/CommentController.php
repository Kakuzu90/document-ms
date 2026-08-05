<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Document;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(StoreCommentRequest $request, Document $document)
    {
        $this->authorize('create', Comment::class);

        $document->comments()->create([
            'user_id' => $request->user()->id,
            'body'    => $request->body,
        ]);

        if ($document->status === DocumentStatus::SUBMITTED) {
            $document->update([
                'status' => DocumentStatus::UNDER_REVIEW,
            ]);
        }

        return redirect()->route('admin.documents.show', $document)
                         ->with('status', 'Comment added successfully.');
    }
}
