<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'order_id',
        'title',
        'description',
        'client_id',
        'status',
        'start_date',
        'end_date',
        'deadline',
        'estimated_hours',
        'spent_hours',
        'visibility',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
        'estimated_hours' => 'decimal:2',
        'spent_hours' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->uuid)) {
                $project->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the order this project belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the client for this project.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the team members assigned to this project.
     */
    public function team(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role', 'notifications_enabled')
            ->withTimestamps();
    }

    /**
     * Get the tasks for this project.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the milestones for this project.
     */
    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class)->orderBy('order');
    }

    /**
     * Get the messages for this project.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ProjectMessage::class)->latest();
    }

    /**
     * Get the files for this project.
     */
    public function files(): MorphMany
    {
        return $this->morphMany(ProjectFile::class, 'model');
    }

    /**
     * Get the activity logs for this project.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(ActivityLog::class)->latest();
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for projects by a specific client.
     */
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Scope for active projects.
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['planning', 'in_progress']);
    }

    /**
     * Scope a query to search projects by keyword.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('uuid', 'like', "%{$search}%")
                ->orWhereHas('order', function ($q) use ($search) {
                    $q->where('uuid', 'like', "%{$search}%");
                })
                ->orWhereHas('client', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $from = null, $to = null)
    {
        if ($from) {
            $query->whereDate('start_date', '>=', $from);
        }
        if ($to) {
            $query->whereDate('end_date', '<=', $to);
        }
        return $query;
    }

    /**
     * Check if user is assigned to this project.
     */
    public function hasTeamMember(User $user): bool
    {
        return $this->team()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if user is the client.
     */
    public function isClient(User $user): bool
    {
        return $this->client_id === $user->id;
    }

    /**
     * Get completion percentage based on tasks.
     */
    public function getCompletionPercentageAttribute(): float
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) {
            return 0;
        }
        
        $completedTasks = $this->tasks()->where('status', 'done')->count();
        return ($completedTasks / $totalTasks) * 100;
    }

    /**
     * Update spent hours from tasks.
     */
    public function updateSpentHours(): void
    {
        $this->spent_hours = $this->tasks()->sum('spent_hours');
        $this->save();
    }

    /**
     * Get the route key name for Laravel.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
                'status',
                'priority',
                'budget',
                'budget_spent',
                'start_date',
                'end_date',
                'actual_start_date',
                'actual_end_date',
                'estimated_hours',
                'actual_hours',
                'completion_percentage',
                'metadata'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Project created',
                'updated' => 'Project updated',
                'deleted' => 'Project deleted',
                default => "Project {$eventName}",
            })
            ->useLogName('projects');
    }
}
