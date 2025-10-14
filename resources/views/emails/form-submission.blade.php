<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #FF4900;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .data-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Form Submission</h1>
    </div>
    
    <div class="content">
        <p>You have received a new submission from <strong>{{ $form->name }}</strong> form.</p>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $field => $value)
                <tr>
                    <td><strong>{{ $field }}</strong></td>
                    <td>{{ is_string($value) ? $value : json_encode($value) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <p>
            This submission was received on {{ date('F j, Y, g:i a') }}.
        </p>
    </div>
    
    <div class="footer">
        <p>This is an automated email from Manifest Digital. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} Manifest Digital. All rights reserved.</p>
    </div>
</body>
</html>