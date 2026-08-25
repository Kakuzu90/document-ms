<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Document;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class StoreComment
{
    public function handle(Document $document, User $user, array $data): void
    {
        DB::transaction(function () use ($document, $user, $data) {
            $comment = $document->comments()->create([
                'user_id'     => $user->id,
                'body'        => $data['body'],
                'parent_id'   => $data['parent_id'] ?? null,
                'quoted_text' => $data['quoted_text'] ?? null,
            ]);

            if ($user->isTeacher()) {
                // Teacher commented, notify all admins
                $admins = User::where('role', 'admin')->get();
                Notification::send($admins, new NewCommentNotification($document, $comment));
            } else {
                // Admin commented, notify the document owner (teacher)
                if ($document->user_id !== $user->id) {
                    $document->user->notify(new NewCommentNotification($document, $comment));
                }
            }
        });
    }
}
