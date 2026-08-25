<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\Document;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Document $document): bool
    {
        if (!$document->isNotReviewed()) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $document->user_id;
    }
}
