<?php

namespace App\Notifications;

use App\Models\ProjectMessage;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProjectMessage extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Project $project,
        public ProjectMessage $message
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Only send email for public messages or if user is internal staff
        $shouldSendEmail = !$this->message->is_internal || $notifiable->hasRole(['Admin', 'Staff']);
        
        return $shouldSendEmail ? ['mail', 'database'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $messagePreview = str($this->message->content)->limit(150);
        
        $mail = (new MailMessage)
            ->subject('New Message in Project: ' . $this->project->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have a new message in project **' . $this->project->title . '**.')
            ->line('**From:** ' . $this->message->user->name)
            ->line('**Message:**')
            ->line($messagePreview);

        if ($this->message->attachments && count($this->message->attachments) > 0) {
            $mail->line('📎 This message includes ' . count($this->message->attachments) . ' attachment(s).');
        }

        $route = $notifiable->hasRole('Customer') 
            ? route('customer.projects.show', $this->project)
            : route('admin.projects.show', $this->project);

        $mail->action('View Project', $route)
            ->line('Reply to continue the conversation.');

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'message_id' => $this->message->id,
            'sender_name' => $this->message->user->name,
            'message_preview' => str($this->message->content)->limit(100),
            'is_internal' => $this->message->is_internal,
            'has_attachments' => $this->message->attachments && count($this->message->attachments) > 0,
            'message' => 'New message from ' . $this->message->user->name . ' in ' . $this->project->title,
        ];
    }
}
