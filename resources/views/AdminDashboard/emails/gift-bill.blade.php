<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Fund Bill</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #bd0f0f;
        }
        .content {
            margin: 20px 0;
            line-height: 1.6;
        }
        .content p {
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
        .highlight {
            color: #bd0f0f;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background-color: #bd0f0f;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #bd0f0f;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Your Fund Bill</h1>
        </div>
        <div class="content">
            <p>Dear <span class="highlight">{{ $gift->member->member_name }}</span>,</p>
            <p>Thank you for your generous contribution! Your donation makes a significant impact by helping us support our community.</p>
            <p>Here are the details of your contribution:</p>
            <ul>
                <li><strong>Type:</strong> {{ $gift->type }}</li>
                <li><strong>Amount:</strong><span class="highlight"> Rs {{ $gift->amount }}</span></li>
            </ul>
            <p>Please find the bill attached to this email.</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p><strong>Church Moratumulla</strong></p>
        </div>
    </div>
</body>
</html>
