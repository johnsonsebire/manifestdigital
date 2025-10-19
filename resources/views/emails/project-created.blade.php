@extends('emails.layouts.app')

@section('title', 'New Project Created')

@section('content')
    <div class="greeting">Hello {{ $notifiable->name }}!</div>
    
    <div class="content-text">
        Exciting news! A new project has been created for your order. Our team is ready to begin work and bring your vision to life.
    </div>
    
    <div class="highlight-box">
        <strong>🚀 Project Launched</strong><br>
        Your project "{{ $project->title }}" has been set up and assigned to our team. You can now track progress, communicate with your team, and stay updated on milestones.
    </div>
    
    <table class="info-table">
        <tr>
            <th>Project Details</th>
            <th>Information</th>
        </tr>
        <tr>
            <td><strong>Project Title</strong></td>
            <td>{{ $project->title }}</td>
        </tr>
        <tr>
            <td><strong>Project ID</strong></td>
            <td>#{{ $project->id }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td><span class="status-badge status-{{ $project->status }}">{{ ucfirst($project->status) }}</span></td>
        </tr>
        <tr>
            <td><strong>Start Date</strong></td>
            <td>{{ $project->start_date ? $project->start_date->format('F d, Y') : 'To be determined' }}</td>
        </tr>
        @if($project->end_date)
        <tr>
            <td><strong>Expected Completion</strong></td>
            <td>{{ $project->end_date->format('F d, Y') }}</td>
        </tr>
        @endif
        @if($project->order_id)
        <tr>
            <td><strong>Related Order</strong></td>
            <td>Order #{{ $project->order_id }}</td>
        </tr>
        @endif
    </table>
    
    @if($project->description)
    <div class="content-text">
        <strong>Project Description:</strong><br>
        {{ $project->description }}
    </div>
    @endif
    
    <div class="button-container">
        <a href="{{ app()->environment('local', 'staging') ? '#project-dashboard' : route('customer.projects.show', $project) }}" class="email-button">
            View Project Dashboard
        </a>
    </div>
    
    <div class="content-text">
        <strong>What You Can Do:</strong>
    </div>
    
    <div class="content-text" style="margin-left: 20px;">
        • <strong>Track Progress:</strong> Monitor project milestones and completion status<br>
        • <strong>Communicate:</strong> Send messages directly to your project team<br>
        • <strong>Review Deliverables:</strong> View and approve completed work<br>
        • <strong>Stay Updated:</strong> Receive notifications on important project updates
    </div>
    
    <div class="content-text">
        Our team is committed to delivering exceptional results. If you have any questions or special requirements, please don't hesitate to reach out through the project dashboard.
    </div>
@endsection