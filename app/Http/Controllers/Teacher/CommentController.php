<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\StoreComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Document;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(StoreCommentRequest $request, Document $document, StoreComment $action)
    {
        $this->authorize('create', [Comment::class, $document]);

        $action->handle($document, $request->user(), $request->validated());

        return redirect()->route('teacher.documents.show', $document)
                         ->with('status', 'Comment added successfully.');
    }
}
