<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
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

        input[type="email"] {
            width: 100%; /* Full width input */
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            margin-bottom: 15px; /* Space below the input */
            transition: border-color 0.3s;
        }

        input[type="email"]:focus {
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

        /* Success and Error Messages */
        .success-message {
            color: green;
            margin-top: 10px;
        }

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

    <!-- Password Reset Form -->
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Password Reset Link</button><br>
        <br>
            <a href="{{route('home')}}"class="btn btn-success"> Back</a>
    </form>

    <!-- Success Message -->
    @if (session('status'))
        <div class="success-message">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <!-- Error Message -->
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