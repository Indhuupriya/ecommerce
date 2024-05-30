<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting</title>
</head>
<body>
    <div style="background-color: #f0f0f0; padding: 20px;">
        <div style="background-color: #ffffff; border-radius: 5px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2>Thank You for Contacting</h2>
            <p>Dear {{ $data->name }},</p>
            <p>Thank you for contacting with our website.  we will contact you shortly.</p>
            <p>If you have any questions or need assistance, please feel free to contact us.</p>
            <p>Your details:</p>
            <strong>Name: </strong><p>{{ $data->name }} </p><br>
            <strong>Email: </strong><p>{{ $data->email }} </p><br>
            <strong>Phone: </strong><p>{{ $data->phonenumber }} </p><br>
            <strong>Address: </strong><p>{{ $data->address }} </p><br>
            <strong>Message: </strong><p>{{ $data->message }}</p> <br><br>

            <p>Best regards,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>

