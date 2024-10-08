<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: "Lato", sans-serif;
            margin: 0;
            background-color: #f0f2f5; /* Light background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height */
        }

        .container {
            background-color: white; /* White background for the container */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 400px; /* Fixed width */
            text-align: center; /* Center text */
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px; /* Space below the title */
        }

        input[type="email"],
        input[type="password"] {
            width: 100%; /* Full width input */
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            margin-bottom: 15px; /* Space below the input */
            transition: border-color 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff; /* Focused input border color */
        }

        button {
            width: 100%; /* Full width button */
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        /* Error Messages */
        .error-message {
            color: red;
            margin-top: 10px;
        }
        ul {
            padding-left: 0;
            list-style-type: none; /* Remove bullet points */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Reset Password</h1>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter new password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm new password" required>
        <button type="submit">Reset Password</button>
    </form>
    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
</body>
</html>
