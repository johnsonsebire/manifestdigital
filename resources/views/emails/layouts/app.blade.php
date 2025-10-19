<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Notification')</title>
    
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #FF4900 0%, #ff6b33 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            opacity: 0.1;
        }
        
        .company-logo {
            position: relative;
            z-index: 1;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: -0.025em;
        }
        
        .company-tagline {
            position: relative;
            z-index: 1;
            font-size: 14px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        /* Content */
        .email-content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        
        .content-text {
            font-size: 16px;
            line-height: 1.7;
            color: #4b5563;
            margin-bottom: 20px;
        }
        
        .content-text strong {
            color: #1f2937;
            font-weight: 600;
        }
        
        .highlight-box {
            background-color: #f3f4f6;
            border-left: 4px solid #FF4900;
            padding: 20px;
            margin: 24px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .info-table th,
        .info-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .info-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }
        
        .info-table td {
            color: #6b7280;
            font-size: 14px;
        }
        
        .info-table tr:last-child td {
            border-bottom: none;
        }
        
        /* Button */
        .email-button {
            display: inline-block;
            background: linear-gradient(135deg, #FF4900 0%, #ff6b33 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 24px 0;
            box-shadow: 0 4px 6px -1px rgba(255, 73, 0, 0.3);
            transition: all 0.2s ease;
        }
        
        .email-button:hover {
            background: linear-gradient(135deg, #e63900 0%, #ff4900 100%);
            box-shadow: 0 6px 12px -1px rgba(255, 73, 0, 0.4);
            transform: translateY(-1px);
        }
        
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-approved { background-color: #d1fae5; color: #065f46; }
        .status-processing { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-sent { background-color: #dbeafe; color: #1e40af; }
        .status-overdue { background-color: #fee2e2; color: #991b1b; }
        
        /* Footer */
        .email-footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer-content {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
        }
        
        .footer-content p {
            margin-bottom: 8px;
        }
        
        .footer-links {
            margin: 16px 0;
        }
        
        .footer-links a {
            color: #FF4900;
            text-decoration: none;
            margin: 0 12px;
            font-weight: 500;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .company-info {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 16px;
            line-height: 1.5;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
            }
            
            .email-header,
            .email-content,
            .email-footer {
                padding: 24px 20px !important;
            }
            
            .greeting {
                font-size: 18px;
            }
            
            .content-text {
                font-size: 15px;
            }
            
            .email-button {
                display: block;
                text-align: center;
                width: 100%;
            }
            
            .info-table th,
            .info-table td {
                padding: 10px 12px;
                font-size: 13px;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #111827;
                color: #e5e7eb;
            }
            
            .email-container {
                background-color: #1f2937;
            }
            
            .email-content {
                background-color: #1f2937;
            }
            
            .greeting {
                color: #f9fafb;
            }
            
            .content-text {
                color: #d1d5db;
            }
            
            .content-text strong {
                color: #f9fafb;
            }
            
            .highlight-box {
                background-color: #374151;
            }
            
            .info-table {
                background-color: #1f2937;
                border-color: #374151;
            }
            
            .info-table th {
                background-color: #374151;
                color: #f9fafb;
            }
            
            .info-table td {
                color: #d1d5db;
                border-color: #374151;
            }
            
            .email-footer {
                background-color: #111827;
                border-color: #374151;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="company-logo">{{ setting('company_name', 'Manifest Digital') }}</div>
            <div class="company-tagline">@yield('tagline', 'Professional Digital Services')</div>
        </div>
        
        <!-- Content -->
        <div class="email-content">
            @yield('content')
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-content">
                <p>Thank you for choosing {{ setting('company_name', 'Manifest Digital') }}!</p>
                
                @if(setting('company_website') || setting('company_email'))
                <div class="footer-links">
                    @if(setting('company_website'))
                        <a href="{{ setting('company_website') }}">Visit Website</a>
                    @endif
                    @if(setting('company_email'))
                        <a href="mailto:{{ setting('company_email') }}">Contact Support</a>
                    @endif
                </div>
                @endif
                
                <div class="company-info">
                    <strong>{{ setting('company_name', 'Manifest Digital') }}</strong><br>
                    @if(setting('company_address'))
                        {{ setting('company_address') }}<br>
                    @endif
                    @if(setting('company_city_state_zip'))
                        {{ setting('company_city_state_zip') }}<br>
                    @endif
                    @if(setting('company_email'))
                        Email: {{ setting('company_email') }}<br>
                    @endif
                    @if(setting('company_phone'))
                        Phone: {{ setting('company_phone') }}<br>
                    @endif
                </div>
                
                <p style="margin-top: 20px; font-size: 11px;">
                    This is an automated email. Please do not reply to this message.<br>
                    © {{ date('Y') }} {{ setting('company_name', 'Manifest Digital') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>