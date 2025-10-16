<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Submission #{{ $submission->id }} - {{ $submission->form->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #FF4900;
        }
        
        .header h1 {
            color: #FF4900;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            background-color: #FF4900;
            color: white;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            width: 35%;
            padding: 8px;
            background-color: #f5f5f5;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }
        
        .info-value {
            display: table-cell;
            width: 65%;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        
        .submitter-section {
            background-color: #fff8f5;
            padding: 15px;
            border-left: 4px solid #FF4900;
            margin-bottom: 20px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Form Submission #{{ $submission->id }}</h1>
        <p><strong>Form:</strong> {{ $submission->form->name }}</p>
        <p><strong>Submitted:</strong> {{ $submission->created_at->format('F d, Y \a\t h:i A') }}</p>
    </div>
    
    @if($submitterInfo['first_name'] || $submitterInfo['last_name'] || $submitterInfo['email'])
    <div class="submitter-section">
        <h2 style="margin-top: 0; color: #FF4900; font-size: 16px;">Submitter Information</h2>
        <div class="info-grid">
            @if($submitterInfo['first_name'])
            <div class="info-row">
                <div class="info-label">First Name</div>
                <div class="info-value">{{ $submitterInfo['first_name'] }}</div>
            </div>
            @endif
            
            @if($submitterInfo['last_name'])
            <div class="info-row">
                <div class="info-label">Last Name</div>
                <div class="info-value">{{ $submitterInfo['last_name'] }}</div>
            </div>
            @endif
            
            @if($submitterInfo['email'])
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $submitterInfo['email'] }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif
    
    <div class="section">
        <div class="section-title">Submission Details</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">IP Address</div>
                <div class="info-value">{{ $submission->ip_address ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">User Agent</div>
                <div class="info-value">{{ $submission->user_agent ?? 'N/A' }}</div>
            </div>
            @if($submission->user)
            <div class="info-row">
                <div class="info-label">Submitted By (Logged In User)</div>
                <div class="info-value">{{ $submission->user->name }} ({{ $submission->user->email }})</div>
            </div>
            @endif
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Submitted Data</div>
        <div class="info-grid">
            @foreach($submission->data as $key => $value)
            <div class="info-row">
                <div class="info-label">{{ \App\Models\FormSubmission::formatFieldName($key) }}</div>
                <div class="info-value">
                    @if(is_array($value))
                        {{ implode(', ', $value) }}
                    @else
                        {{ $value ?: 'N/A' }}
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="footer">
        <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
