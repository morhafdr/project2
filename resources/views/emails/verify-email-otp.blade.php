<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4CAF50;
        }
        .content {
            text-align: center;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #4CAF50;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Email Verification</h1>
    </div>

    <div class="content">
        <p>Dear user,</p>
        <p>Thank you for registering with us. Please use the following OTP code to verify your email address:</p>

        <div class="otp-code">{{ $code }}</div>

        <p>This OTP is valid for the next 10 minutes. If you did not request this, please ignore this email.</p>
    </div>

    <div class="footer">
        <p>Thank you for using our service!</p>
        <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
    </div>
</div>
</body>
</html>
