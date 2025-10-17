<?php

namespace App\Events;

use App\Models\Order;
use App\Models\Project;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Project $project;
    public ?Order $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Project $project, ?Order $order = null)
    {
        $this->project = $project;
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('projects.' . $this->project->id),
        ];
    }
}
