<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentReviewedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Document $document
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('teacher.documents.show', $this->document);

        return (new MailMessage)
                    ->subject("Document Reviewed: {$this->document->title}")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("Your document **{$this->document->title}** has been reviewed.")
                    ->line("Its status is now: **{$this->document->status->label()}**.")
                    ->action('View Details', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'document_id' => $this->document->id,
            'title' => $this->document->title,
            'status' => $this->document->status->value,
            'message' => "Your document '{$this->document->title}' has been reviewed.",
        ];
    }
}
