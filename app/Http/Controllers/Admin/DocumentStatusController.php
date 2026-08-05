<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\StatusHistory;
use App\Notifications\DocumentReviewedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DocumentStatusController extends Controller
{
    /**
     * Update the status of the specified document.
     */
    public function update(\App\Http\Requests\UpdateDocumentStatusRequest $request, Document $document)
    {
        $this->authorize('updateStatus', $document);

        $newStatusValue = $request->validated('status');


        if ($newStatusValue === $document->status->value) {
            return redirect()->back()->with('status', 'Status is already set to ' . $document->status->label() . '.');
        }

        $oldStatus = $document->status;
        $newStatusEnum = DocumentStatus::from($newStatusValue);

        DB::transaction(function () use ($document, $oldStatus, $newStatusEnum) {
            StatusHistory::create([
                'document_id' => $document->id,
                'changed_by' => auth()->id(),
                'from_status' => $oldStatus->value,
                'to_status' => $newStatusEnum->value,
            ]);

            $document->update(['status' => $newStatusEnum->value]);
        });

        if (in_array($newStatusEnum, [DocumentStatus::REVIEWED, DocumentStatus::NEEDS_REVISION])) {
            $document->user->notify(new DocumentReviewedNotification($document));
        }

        return redirect()->back()->with('status', 'Document status updated to ' . $newStatusEnum->label() . ' successfully.');
    }
}
