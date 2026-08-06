<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentSubmittedNotification extends Notification
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
        $url = route('admin.documents.show', $this->document);

        return (new MailMessage)
                    ->subject("New Document Submitted: {$this->document->title}")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("**{$this->document->user->name}** submitted a new document for review: **{$this->document->title}**.")
                    ->action('Review Document', $url)
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
            'teacher_name' => $this->document->user->name,
            'message' => "New document submitted: {$this->document->title}",
        ];
    }
}
