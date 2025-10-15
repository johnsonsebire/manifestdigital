# Form Builder Integration Guide

## Overview
This guide explains how to integrate your custom static forms with the Form Builder module for centralized submission handling, storage, and email notifications.

## Benefits

✅ **Centralized Management**: All form submissions in one place (Admin Panel)  
✅ **Email Notifications**: Automatic email alerts for new submissions  
✅ **Data Storage**: Submissions stored in database with IP tracking  
✅ **Validation**: Automatic server-side validation based on field rules  
✅ **Error Handling**: Built-in error messages and validation feedback  
✅ **Flexibility**: Keep your custom form design, use centralized backend  

---

## Implementation Steps

### 1. Create Form Definition in Database

Create a seeder for each form (like we did for "Book a Call"):

```bash
php artisan make:seeder RequestQuoteFormSeeder
```

### 2. Update Your Form HTML

**Before:**
```html
<form id="myForm" action="/custom-endpoint" method="POST">
    <!-- fields -->
</form>
```

**After:**
```html
<form id="myForm" action="{{ route('forms.submit', 'your-form-slug') }}" method="POST">
    @csrf
    <!-- fields with Laravel validation -->
</form>
```

### 3. Add Laravel Validation & Error Display

For each field, add:
- `@csrf` token
- `value="{{ old('fieldName') }}"` for persistence
- `@error` directives for validation messages

**Example:**
```blade
<input 
    type="email" 
    name="email" 
    value="{{ old('email') }}" 
    class="@error('email') is-invalid @enderror"
    required>
@error('email')
    <small class="text-danger">{{ $message }}</small>
@enderror
```

### 4. Add Success/Error Messages

```blade
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
```

---

## Completed Integrations

### ✅ Book a Call Form
- **Slug**: `book-a-call`
- **Route**: `{{ route('forms.submit', 'book-a-call') }}`
- **Fields**: firstName, lastName, email, phone, meetingType, preferredDate, preferredTime, timezone, projectDetails
- **Email**: Sends notifications to configured email
- **Status**: Fully integrated

---

## Forms To Integrate

### 📋 Request Quote Form
**Location**: `/request-quote`  
**Fields Needed**:
- Name
- Email
- Phone
- Company (optional)
- Project Type (select)
- Budget Range (select)
- Project Description (textarea)
- Timeline (select)

### 📋 Contact Form
**Location**: `/contact`  
**Fields Needed**:
- Name
- Email
- Subject
- Message

### 📋 Team Profile Form
**Location**: `/team-profile/create`  
**Status**: Already has custom controller - can optionally integrate

---

## Creating a New Form Integration

### Step 1: Create the Seeder

```php
<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Database\Seeder;

class YourFormSeeder extends Seeder
{
    public function run(): void
    {
        $form = Form::updateOrCreate(
            ['slug' => 'your-form-slug'],
            [
                'name' => 'Your Form Name',
                'title' => 'Form Title',
                'description' => 'Form description',
                'success_message' => 'Thank you! We will contact you soon.',
                'submit_button_text' => 'Submit',
                'store_submissions' => true,
                'send_notifications' => true,
                'notification_email' => env('MAIL_FROM_ADDRESS'),
                'is_active' => true,
                'requires_login' => false,
                'recaptcha_status' => 'disabled',
                'shortcode' => '[form id="your-form-slug"]',
            ]
        );

        $form->fields()->delete();

        $fields = [
            [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Email Address',
                'placeholder' => 'your@email.com',
                'is_required' => true,
                'order' => 1,
            ],
            // Add more fields...
        ];

        foreach ($fields as $fieldData) {
            FormField::create(array_merge(['form_id' => $form->id], $fieldData));
        }
    }
}
```

### Step 2: Run the Seeder

```bash
php artisan db:seed --class=YourFormSeeder
```

### Step 3: Update the Form HTML

Update the form action and add Laravel blade directives as shown above.

---

## Field Types Available

- `text` - Text input
- `textarea` - Multi-line text
- `email` - Email input (with validation)
- `number` - Number input
- `select` - Dropdown select
- `checkbox` - Checkbox
- `radio` - Radio buttons
- `date` - Date picker
- `file` - File upload
- `hidden` - Hidden field
- `phone` - Phone number
- `url` - URL input

---

## Admin Panel Access

View all submissions at:
**Admin > Forms > [Form Name] > Submissions**

You can:
- View all submissions
- Filter by date
- Export submissions
- See submission details
- Track IP addresses

---

## Email Configuration

Update the notification email in `.env`:

```env
MAIL_FROM_ADDRESS=your-email@manifestghana.com
MAIL_FROM_NAME="Manifest Digital"
```

Email templates are located at:
- `resources/views/emails/form-submission.blade.php` (HTML)
- `resources/views/emails/form-submission-text.blade.php` (Plain text)

---

## AJAX Submissions (Optional)

The controller supports AJAX submissions. For AJAX:

```javascript
fetch('/forms/your-slug/submit', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
    },
    body: JSON.stringify(formData)
})
.then(response => response.json())
.then(data => {
    if(data.success) {
        // Show success message
    } else {
        // Show validation errors
    }
});
```

---

## Next Steps

1. ✅ Book a Call - COMPLETED
2. ⏳ Create seeder for Request Quote form
3. ⏳ Create seeder for Contact form
4. ⏳ Update form HTML for Request Quote
5. ⏳ Update form HTML for Contact
6. ⏳ Test all integrations
7. ⏳ Configure email templates

---

## Support

For issues or questions, check:
- Form Builder routes: `routes/forms.php`
- Controller: `app/Http/Controllers/FormSubmissionController.php`
- Models: `app/Models/Form.php`, `app/Models/FormField.php`
