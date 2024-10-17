<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="stylesheet" href="{{asset('css/myfile1.css')}}">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #343a40;
        }

        p {
            text-align: center;
            color: #495057;
        }

        .reset-btn {
            display: block;
            width: 100%;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Hello {{ $name }},</h1>
        <p>You requested to reset your password. Click the link below to reset it:</p>
        <p>
            <a href="{{ route('password.reset', ['id' => $user->id]) }}" class="btn btn-primary reset-btn">Reset
                Password</a>
        </p>
        <p>This link will expire in 3 minutes.</p>
        <p>If you did not request this, please ignore this email.</p>
    </div>
</body>

</html>