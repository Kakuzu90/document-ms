<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ReplaceDocument
{
    /**
     * Replace the document file and log a system comment.
     */
    public function handle(Document $document, UploadedFile $file, int $userId): Document
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/' . $document->user_id, $filename);

        if ($document->file_path && Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        $document->update(['file_path' => $path]);

        $document->comments()->create([
            'user_id' => $userId,
            'body' => 'System Note: The document file was replaced/annotated by the administrator.',
        ]);

        return $document;
    }
}
