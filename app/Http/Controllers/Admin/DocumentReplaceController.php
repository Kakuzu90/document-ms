<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Http\Requests\Admin\ReplaceDocumentRequest;
use Illuminate\Http\RedirectResponse;
use App\Actions\ReplaceDocument;

class DocumentReplaceController extends Controller
{
    /**
     * Replace the document file with an annotated one.
     */
    public function update(ReplaceDocumentRequest $request, Document $document, ReplaceDocument $action): RedirectResponse
    {
        $this->authorize('updateStatus', $document); // Admins only, same authorization logic

        $validated = $request->validated();

        $action->handle($document, $request->file('document'), $request->user()->id);

        return redirect()->route('admin.documents.show', $document)->with('success', 'Document replaced with annotated version successfully.');
    }
}
