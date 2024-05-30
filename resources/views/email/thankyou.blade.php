<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Registering</title>
</head>
<body>
    <div style="background-color: #f0f0f0; padding: 20px;">
        <div style="background-color: #ffffff; border-radius: 5px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2>Thank You for Registering</h2>
            <p>Dear {{ $user->fname }},</p>
            <p>Thank you for registering with our website. We're excited to have you as a member of our community.</p>
            <p>If you have any questions or need assistance, please feel free to contact us.</p>
            <p>Best regards,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
