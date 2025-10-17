<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Project $project
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Project Created: ' . $this->project->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Great news! A new project has been created for your order.')
            ->line('**Project:** ' . $this->project->title)
            ->line('**Status:** ' . ucfirst($this->project->status))
            ->line('**Start Date:** ' . ($this->project->start_date ? $this->project->start_date->format('F d, Y') : 'To be determined'))
            ->action('View Project', route('customer.projects.show', $this->project))
            ->line('You can track the progress and communicate with our team through the project dashboard.')
            ->line('Thank you for choosing our services!');
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
            'project_status' => $this->project->status,
            'message' => 'New project created: ' . $this->project->title,
        ];
    }
}
