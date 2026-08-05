<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StoreComment
{
    public function handle(Document $document, User $user, array $data): void
    {
        DB::transaction(function () use ($document, $user, $data) {
            $document->comments()->create([
                'user_id'     => $user->id,
                'body'        => $data['body'],
                'parent_id'   => $data['parent_id'] ?? null,
                'quoted_text' => $data['quoted_text'] ?? null,
            ]);
        });
    }
}
