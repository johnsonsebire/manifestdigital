@extends('emails.layouts.app')

@section('title', 'New Form Submission')

@section('tagline', 'Form Submission Notification')

@section('content')
    <div class="greeting">New Form Submission Received</div>
    
    <div class="content-text">
        You have received a new submission from the <strong>{{ $form->name }}</strong> form on your website.
    </div>
    
    <div class="highlight-box">
        <strong>📋 Form Details</strong><br>
        Form: {{ $form->name }}<br>
        Submitted: {{ date('F j, Y, g:i a') }}<br>
        @if(isset($submissionId))
        Submission ID: #{{ $submissionId }}
        @endif
    </div>
    
    <div class="content-text">
        <strong>Submitted Data:</strong>
    </div>
    
    <table class="info-table">
        <thead>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $field => $value)
            <tr>
                <td><strong>{{ ucwords(str_replace(['_', '-'], ' ', $field)) }}</strong></td>
                <td>
                    @if(is_array($value))
                        {{ implode(', ', $value) }}
                    @elseif(is_string($value) && filter_var($value, FILTER_VALIDATE_EMAIL))
                        <a href="mailto:{{ $value }}" style="color: #FF4900;">{{ $value }}</a>
                    @elseif(is_string($value) && filter_var($value, FILTER_VALIDATE_URL))
                        <a href="{{ $value }}" style="color: #FF4900;" target="_blank">{{ $value }}</a>
                    @else
                        {{ is_string($value) ? $value : json_encode($value) }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if(isset($adminUrl))
    <div class="button-container">
        <a href="{{ $adminUrl }}" class="email-button">
            View in Admin Panel
        </a>
    </div>
    @endif
    
    <div class="content-text">
        This submission has been automatically saved to your form submissions database. You can review, respond to, and manage all form submissions through your admin dashboard.
    </div>
@endsection