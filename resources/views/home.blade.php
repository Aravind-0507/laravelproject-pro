<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: "Lato", sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f0f2f5;
            overflow: hidden;
        }

        .navbar {
            background-color: #007bff;
            padding: 10px 20px;
            color: white;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
            margin-bottom: 60px;
            height: 50px;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .sidenav {
            height: calc(100vh - 50px);
            width: 200px;
            position: fixed;
            z-index: 1;
            top: 50px;
            left: 0;
            background-color: #111;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
        }

        .sidenav a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #f8f9fa;
            display: block;
            transition: background-color 0.3s;
        }

        .sidenav a:hover {
            background-color: #007bff;
        }

        .main-content {
            margin-left: 220px;
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: calc(100% - 220px);
            padding: 20px;
            flex: 1;
            overflow: auto;
            height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-right: 160px;
            margin-bottom: 60px;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-inline {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #007bff;
        }

        .btn-primary {
            width: 100%;
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

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .text-danger {
            color: #ff5b5b;
            font-size: 12px;
            margin-top: 5px;
        }

        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px;
            left: 0;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h1>My Application</h1>
    </div>

    <div class="main-content">
        <div class="card">
            <div class="card-body">
                <h1>Login</h1>

                <form method="POST" action="{{ route('login') }}" class="form-inline">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email"
                            required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter your password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form><br>

                <div class="mt-3 text-center">
                    <a href="{{ route('password.request') }}" class="text-primary">Forgot your password?</a>
                </div>

            </div>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 My Application. All Rights Reserved.</p>
    </div>
</body>

</html>