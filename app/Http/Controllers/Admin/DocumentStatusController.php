<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UpdateDocumentStatus;
use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentStatusController extends Controller
{
    /**
     * Update the status of the specified document.
     */
    public function update(\App\Http\Requests\UpdateDocumentStatusRequest $request, Document $document, UpdateDocumentStatus $action)
    {
        $this->authorize('updateStatus', $document);

        $newStatusValue = $request->validated('status');

        if ($newStatusValue === $document->status->value) {
            return redirect()->back()->with('status', 'Status is already set to ' . $document->status->label() . '.');
        }

        $newStatusEnum = DocumentStatus::from($newStatusValue);

        $action->handle($document, $newStatusEnum, $request->user());

        return redirect()->back()->with('status', 'Document status updated to ' . $newStatusEnum->label() . ' successfully.');
    }
}
