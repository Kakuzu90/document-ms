<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\DocumentSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleDocumentSubmission
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DocumentSubmitted $event): void
    {
        // Implementation for Module 5
        // $document = $event->document;
    }
}
