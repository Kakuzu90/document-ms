<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Document $document,
        public Comment $comment
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
        $url = route($notifiable->dashboardRoute());
        if ($notifiable->isTeacher()) {
            $url = route('teacher.documents.show', $this->document);
        } elseif ($notifiable->isAdmin()) {
            $url = route('admin.documents.show', $this->document);
        }

        return (new MailMessage)
                    ->subject("New Comment on: {$this->document->title}")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("**{$this->comment->user->name}** left a new comment on the document **{$this->document->title}**.")
                    ->line("> \"{$this->comment->body}\"")
                    ->action('View Document', $url)
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
            'comment_id' => $this->comment->id,
            'commenter_name' => $this->comment->user->name,
            'message' => "{$this->comment->user->name} commented on {$this->document->title}",
        ];
    }
}
