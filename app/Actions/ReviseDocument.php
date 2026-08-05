<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\DocumentStatus;
use App\Events\DocumentSubmitted;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ReviseDocument
{
    public function handle(Document $document, User $user, UploadedFile $file, ?string $note): void
    {
        DB::transaction(function () use ($document, $user, $file, $note) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = $originalName . '_revised_' . time() . '.' . $extension;

            $path = $file->storeAs('documents/' . $user->id, $filename);

            $document->update(['file_path' => $path]);

            if ($note) {
                $document->comments()->create([
                    'user_id' => $user->id,
                    'body' => $note,
                ]);
            }

            if ($document->status === DocumentStatus::NEEDS_REVISION) {
                $document->update(['status' => DocumentStatus::SUBMITTED]);
            }

            DocumentSubmitted::dispatch($document);
        });
    }
}
