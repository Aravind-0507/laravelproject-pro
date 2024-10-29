<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Menu</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        h2 {
            color: #555;
            margin-top: 20px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #f44336;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-secondary:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    
<div class="container">
    <h1>User Stocks</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="welcome-message">Welcome, {{ $user->name }}!</div>
    <a href="{{ route('users.assign_stocks', $user->id) }}" class="btn">Re-Assign Stock</a>
    <table>
        <thead>
            <tr>
                <th>Stock Name</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @if ($stocks->isEmpty())
                <tr>
                    <td colspan="3" class="text-center">No stocks assigned yet.</td>
                </tr>
            @else
                @foreach ($stocks as $stock)
                    <tr>
                        <td><strong>{{ $stock->name }}</strong></td>
                        <td>{{ $stock->pivot->assigned_quantity }}</td>
                        <td>{{ $stock->status }}</td>
                    </tr>
                @endforeach
                @endif
        </tbody>
    </table>
    <div class="back-link">
        <a href="{{ route('home') }}" class="btn btn-secondary">Back to Login</a>
    </div>
</div>
</body>

</html>