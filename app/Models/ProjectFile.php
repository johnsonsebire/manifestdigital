<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class ProjectFile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'uploader_id',
        'path',
        'original_name',
        'mime_type',
        'size',
        'description',
    ];

    /**
     * Get the owning model (Project, Task, or ProjectMessage).
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who uploaded this file.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the file extension.
     */
    public function getExtensionAttribute(): string
    {
        return pathinfo($this->original_name, PATHINFO_EXTENSION);
    }

    /**
     * Get download URL (signed).
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('files.download', $this->id);
    }

    /**
     * Check if file is an image.
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }

    /**
     * Delete file from storage when model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            Storage::delete($file->path);
        });
    }
}
