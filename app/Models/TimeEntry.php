<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeEntry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'minutes',
        'notes',
        'started_at',
        'stopped_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'stopped_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($timeEntry) {
            // Update task spent hours
            $timeEntry->task->updateSpentHours();
        });

        static::deleted(function ($timeEntry) {
            // Update task spent hours
            $timeEntry->task->updateSpentHours();
        });
    }

    /**
     * Get the task this time entry belongs to.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who logged this time.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for time entries by a specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for time entries within a date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('started_at', [$startDate, $endDate]);
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDurationAttribute(): string
    {
        $hours = floor($this->minutes / 60);
        $mins = $this->minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $mins . 'm';
        }
        
        return $mins . 'm';
    }

    /**
     * Get hours as decimal.
     */
    public function getHoursAttribute(): float
    {
        return round($this->minutes / 60, 2);
    }

    /**
     * Calculate minutes from start/stop times if not set.
     */
    public function calculateMinutes(): void
    {
        if ($this->started_at && $this->stopped_at) {
            $this->minutes = $this->started_at->diffInMinutes($this->stopped_at);
        }
    }
}
