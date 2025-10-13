<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id_key',
        'name',
        'role',
        'photo',
        'contact',
        'bio',
        'skills',
        'experience',
        'achievements',
        'is_active',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'contact' => 'array',
        'skills' => 'array',
        'experience' => 'array',
        'achievements' => 'array',
        'is_active' => 'boolean',
    ];
}
