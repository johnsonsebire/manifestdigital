<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'parent_id',
        'description',
        'metadata',
        'visible',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'visible' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->uuid)) {
                $category->uuid = (string) Str::uuid();
            }
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('title') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    /**
     * Get the parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get all descendants (children, grandchildren, etc.).
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors (parent, grandparent, etc.).
     */
    public function ancestors()
    {
        $ancestors = collect();
        $category = $this->parent;

        while ($category) {
            $ancestors->push($category);
            $category = $category->parent;
        }

        return $ancestors;
    }

    /**
     * Get the services in this category.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'category_service')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include visible categories.
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    /**
     * Scope a query to only include root categories (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to only include categories with a specific parent.
     */
    public function scopeParent($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    /**
     * Check if this category has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Check if this category is a root category.
     */
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Get the full path of the category (e.g., "Development > Web Apps > E-commerce").
     */
    public function getFullPathAttribute(): string
    {
        $path = collect([$this->title]);
        $ancestors = $this->ancestors();

        if ($ancestors->isNotEmpty()) {
            $path = $ancestors->reverse()->pluck('title')->concat($path);
        }

        return $path->implode(' > ');
    }

    /**
     * Get the route key name for Laravel.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
