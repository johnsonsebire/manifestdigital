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
        'submitted_at' => 'datetime',
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

    /**
     * Scope a query to filter by form.
     */
    public function scopeForForm($query, $formId)
    {
        return $query->where('form_id', $formId);
    }

    /**
     * Scope a query to search submissions by data content.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            // Search in JSON data (works in MySQL, PostgreSQL, SQLite)
            $q->where('data', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('form', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $from = null, $to = null)
    {
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
        return $query;
    }

    /**
     * Format field name to human-readable format.
     * Converts: ProjectTitle => Project Title, first_name => First Name
     */
    public static function formatFieldName($fieldName)
    {
        // Handle camelCase: ProjectTitle => Project Title
        $formatted = preg_replace('/([a-z])([A-Z])/', '$1 $2', $fieldName);
        
        // Handle snake_case and spaces: project_title => Project Title
        $formatted = str_replace(['_', '-'], ' ', $formatted);
        
        // Capitalize first letter of each word
        return ucwords($formatted);
    }

    /**
     * Get submitter's first name from form data.
     */
    public function getFirstName()
    {
        // Try common field name variations
        $possibleKeys = ['first_name', 'firstName', 'FirstName', 'fname', 'name'];
        
        foreach ($possibleKeys as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
        
        // Try to extract from full name
        if (isset($this->data['full_name']) || isset($this->data['name'])) {
            $fullName = $this->data['full_name'] ?? $this->data['name'];
            $nameParts = explode(' ', $fullName);
            return $nameParts[0] ?? null;
        }
        
        return null;
    }

    /**
     * Get submitter's last name from form data.
     */
    public function getLastName()
    {
        // Try common field name variations
        $possibleKeys = ['last_name', 'lastName', 'LastName', 'lname', 'surname'];
        
        foreach ($possibleKeys as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
        
        // Try to extract from full name
        if (isset($this->data['full_name']) || isset($this->data['name'])) {
            $fullName = $this->data['full_name'] ?? $this->data['name'];
            $nameParts = explode(' ', $fullName);
            array_shift($nameParts); // Remove first name
            return implode(' ', $nameParts) ?: null;
        }
        
        return null;
    }

    /**
     * Get submitter's email from form data.
     */
    public function getEmail()
    {
        // Try common field name variations
        $possibleKeys = ['email', 'Email', 'email_address', 'emailAddress'];
        
        foreach ($possibleKeys as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
        
        return null;
    }

    /**
     * Get submitter information (first name, last name, email).
     */
    public function getSubmitterInfo()
    {
        return [
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'email' => $this->getEmail(),
        ];
    }
}

