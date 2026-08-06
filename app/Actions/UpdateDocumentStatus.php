<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\DocumentStatus;
use App\Models\Document;
use App\Models\StatusHistory;
use App\Models\User;
use App\Notifications\DocumentReviewedNotification;
use Illuminate\Support\Facades\DB;

class UpdateDocumentStatus
{
    /**
     * Update the document status and record history.
     */
    public function handle(Document $document, DocumentStatus $newStatusEnum, User $user): void
    {
        $oldStatus = $document->status;

        DB::transaction(function () use ($document, $oldStatus, $newStatusEnum, $user) {
            StatusHistory::create([
                'document_id' => $document->id,
                'changed_by' => $user->id,
                'from_status' => $oldStatus->value,
                'to_status' => $newStatusEnum->value,
            ]);

            $document->update(['status' => $newStatusEnum->value]);
        });

        if (in_array($newStatusEnum, [DocumentStatus::REVIEWED, DocumentStatus::NEEDS_REVISION])) {
            $document->user->notify(new DocumentReviewedNotification($document));
        }
    }
}
