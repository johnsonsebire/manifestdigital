<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'form_id',
        'user_id',
        'data',
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the form that owns the submission.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Get the user that made the submission.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get a specific value from the submission data.
     */
    public function getValue($fieldName)
    {
        return $this->data[$fieldName] ?? null;
    }
}
