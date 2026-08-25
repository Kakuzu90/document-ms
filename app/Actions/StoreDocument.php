<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\DocumentStatus;
use App\Events\DocumentSubmitted;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class StoreDocument
{
    /**
     * Store a newly created document.
     */
    public function handle(User $user, array $data, UploadedFile $file): Document
    {
        $path = $file->store('documents/' . $user->id);

        $document = $user->documents()->create([
            'title'     => $data['title'],
            'type'      => $data['type'],
            'file_path' => $path,
            'status'    => DocumentStatus::SUBMITTED,
        ]);

        DocumentSubmitted::dispatch($document);

        return $document;
    }
}
