<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProjectMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'sender_id',
        'body',
        'is_internal',
        'read_by',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_internal' => 'boolean',
        'read_by' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the project this message belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the sender of this message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the files attached to this message.
     */
    public function files(): MorphMany
    {
        return $this->morphMany(ProjectFile::class, 'model');
    }

    /**
     * Scope for client-visible messages.
     */
    public function scopeClientVisible($query)
    {
        return $query->where('is_internal', false);
    }

    /**
     * Scope for internal messages.
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    /**
     * Check if message is client-visible.
     */
    public function isClientVisible(): bool
    {
        return !$this->is_internal;
    }

    /**
     * Check if message was AI generated.
     */
    public function isAiDraft(): bool
    {
        return isset($this->metadata['ai_draft']) && $this->metadata['ai_draft'];
    }

    /**
     * Mark message as read by user.
     */
    public function markAsReadBy(User $user): void
    {
        $readBy = $this->read_by ?? [];
        
        if (!in_array($user->id, $readBy)) {
            $readBy[] = $user->id;
            $this->update(['read_by' => $readBy]);
        }
    }

    /**
     * Check if user has read this message.
     */
    public function isReadBy(User $user): bool
    {
        $readBy = $this->read_by ?? [];
        return in_array($user->id, $readBy);
    }
}
