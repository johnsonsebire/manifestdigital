<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'assignee_id',
        'reporter_id',
        'due_date',
        'start_date',
        'estimated_hours',
        'spent_hours',
        'order_item_id',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'due_date' => 'date',
        'start_date' => 'date',
        'estimated_hours' => 'decimal:2',
        'spent_hours' => 'decimal:2',
    ];

    /**
     * Get the project this task belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the assignee for this task.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Get the reporter who created this task.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the order item this task is linked to.
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the time entries for this task.
     */
    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    /**
     * Get the files for this task.
     */
    public function files(): MorphMany
    {
        return $this->morphMany(ProjectFile::class, 'model');
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for tasks assigned to a specific user.
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assignee_id', $userId);
    }

    /**
     * Scope for high priority tasks.
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', '>=', 2);
    }

    /**
     * Scope for overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->whereNotIn('status', ['done']);
    }

    /**
     * Check if task is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date && 
               $this->due_date->isPast() && 
               !in_array($this->status, ['done']);
    }

    /**
     * Check if task was AI generated.
     */
    public function isAiGenerated(): bool
    {
        return isset($this->metadata['ai_source']) && $this->metadata['ai_source'];
    }

    /**
     * Update spent hours from time entries.
     */
    public function updateSpentHours(): void
    {
        $this->spent_hours = $this->timeEntries()->sum('minutes') / 60;
        $this->save();
        
        // Update project spent hours
        $this->project->updateSpentHours();
    }

    /**
     * Get priority label.
     */
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            0 => 'Low',
            1 => 'Medium',
            2 => 'High',
            3 => 'Urgent',
            default => 'Medium',
        };
    }

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'description',
                'status',
                'priority',
                'assignee_id',
                'due_date',
                'start_date',
                'estimated_hours',
                'spent_hours',
                'metadata'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Task created',
                'updated' => 'Task updated',
                'deleted' => 'Task deleted',
                default => "Task {$eventName}",
            })
            ->useLogName('tasks');
    }
}
