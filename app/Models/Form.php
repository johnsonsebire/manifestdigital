<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Form extends Model
{
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'title',
        'slug',
        'description',
        'success_message',
        'success_page_url',
        'submit_button_text',
        'store_submissions',
        'send_notifications',
        'notification_email',
        'is_active',
        'requires_login',
        'recaptcha_status',
        'shortcode',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'store_submissions' => 'boolean',
        'send_notifications' => 'boolean',
        'is_active' => 'boolean',
        'requires_login' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($form) {
            // Generate a slug if not provided
            if (!$form->slug) {
                $form->slug = \Illuminate\Support\Str::slug($form->name);
            }
            
            // Generate a unique shortcode if not provided
            if (!$form->shortcode) {
                $form->shortcode = 'form_' . \Illuminate\Support\Str::random(8);
            }
        });
    }

    /**
     * Get the fields for the form.
     */
    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }

    /**
     * Get the submissions for the form.
     */
    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    /**
     * Check if the form is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get the shortcode for including the form in content.
     */
    public function getShortcodeAttribute($value): string
    {
        return '[form id="' . $this->id . '"]';
    }

    /**
     * Check if the form requires reCAPTCHA.
     */
    public function requiresRecaptcha(): bool
    {
        return $this->recaptcha_status !== 'disabled';
    }

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'title',
                'description',
                'is_active',
                'requires_login',
                'recaptcha_status',
                'store_submissions',
                'send_notifications',
                'notification_email'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Form created',
                'updated' => 'Form updated',
                'deleted' => 'Form deleted',
                default => "Form {$eventName}",
            })
            ->useLogName('forms');
    }
}
