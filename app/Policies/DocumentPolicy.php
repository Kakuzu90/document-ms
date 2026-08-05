<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isTeacher() || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isTeacher() && $user->id === $document->user_id;
    }

    /**
     * Determine whether the user can update the status of the document.
     */
    public function updateStatus(User $user, Document $document): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can revise the document.
     */
    public function revise(User $user, Document $document): bool
    {
        return $user->isTeacher() && $user->id === $document->user_id;
    }
}
