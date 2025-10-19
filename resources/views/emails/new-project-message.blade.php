@extends('emails.layouts.app')

@section('title', 'New Project Message')

@section('content')
    <div class="greeting">Hello {{ $notifiable->name }}!</div>
    
    <div class="content-text">
        You have received a new message regarding your project <strong>"{{ $project->title }}"</strong>.
    </div>
    
    <table class="info-table">
        <tr>
            <th>Message Details</th>
            <th>Information</th>
        </tr>
        <tr>
            <td><strong>Project</strong></td>
            <td>{{ $project->title }}</td>
        </tr>
        <tr>
            <td><strong>From</strong></td>
            <td>{{ $message->user->name }} ({{ $message->user->hasRole('admin') ? 'Team Member' : 'Client' }})</td>
        </tr>
        <tr>
            <td><strong>Date</strong></td>
            <td>{{ $message->created_at->format('F d, Y g:i A') }}</td>
        </tr>
        <tr>
            <td><strong>Subject</strong></td>
            <td>{{ $message->subject ?? 'Project Update' }}</td>
        </tr>
    </table>
    
    <div class="highlight-box">
        <strong>Message:</strong><br>
        {{ $message->message }}
    </div>
    
    @if($message->attachments && count($message->attachments) > 0)
    <div class="content-text">
        <strong>Attachments:</strong>
    </div>
    
    <table class="info-table">
        @foreach($message->attachments as $attachment)
        <tr>
            <td>📎 {{ $attachment['name'] }}</td>
            <td>{{ $attachment['size'] ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    
    <div class="button-container">
        <a href="{{ app()->environment('local', 'staging') ? '#project-messages' : route('customer.projects.show', $project) }}" class="email-button">
            View Project & Reply
        </a>
    </div>
    
    <div class="content-text">
        You can reply to this message and view the complete conversation thread through your project dashboard. All project communication is kept organized in one place for your convenience.
    </div>
    
    @if($project->status === 'completed')
    <div class="highlight-box" style="background-color: #d1fae5; border-left-color: #10b981;">
        <strong>✓ Project Status:</strong> This project has been completed. Please review the final deliverables and let us know if you need any revisions.
    </div>
    @elseif($project->status === 'in_progress')
    <div class="content-text">
        <strong>Project Status:</strong> This project is currently in progress. Our team is working hard to deliver quality results on time.
    </div>
    @endif
@endsection