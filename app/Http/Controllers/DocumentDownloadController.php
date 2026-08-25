<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentDownloadController extends Controller
{
    /**
     * Download the specified document file.
     */
    public function download(Document $document): StreamedResponse
    {
        $this->authorize('view', $document);

        if (!$document->file_path || !Storage::exists($document->file_path)) {
            abort(404, 'Document file not found.');
        }

        return Storage::download($document->file_path, $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION));
    }
}
