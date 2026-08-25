<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\UserRole;
use App\Events\DocumentSubmitted;
use App\Models\User;
use App\Notifications\DocumentSubmittedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
        $admins = User::where('role', UserRole::ADMIN->value)->get();
        
        Notification::send($admins, new DocumentSubmittedNotification($event->document));
    }
}
