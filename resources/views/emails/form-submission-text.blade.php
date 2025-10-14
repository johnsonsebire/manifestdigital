New Form Submission

You have received a new submission from {{ $form->name }} form.

Form Data:
@foreach($data as $field => $value)
- {{ $field }}: {{ is_string($value) ? $value : json_encode($value) }}
@endforeach

This submission was received on {{ date('F j, Y, g:i a') }}.

---
This is an automated email from Manifest Digital. Please do not reply to this email.
© {{ date('Y') }} Manifest Digital. All rights reserved.