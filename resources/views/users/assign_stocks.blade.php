<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Stocks</title>
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
            max-width: 600px;
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

        .form-label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-select, .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        <h1>Assign Stocks</h1>
        
        <form action="{{ route('users.store_stock') }}" method="POST">
            @csrf
            @if ($stocks->isEmpty())
                <div class="alert alert-warning">No stocks available with quantity less than 50.</div>
            @else
                <div class="mb-3">
                    <label for="stock_id" class="form-label">Select Stock</label>
                    <select name="stock_id" class="form-select" required>
                        <option value="">-- Select a Stock --</option>
                        @foreach ($stocks as $stock)
                            <option value="{{ $stock->id }}">{{ $stock->name }} (Available: {{ $stock->quantity }})</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="mb-3">
                <label for="assigned_quantity" class="form-label">Quantity to Assign</label>
                <br>
                <input type="number" name="assigned_quantity" class="form-control" required min="1">
            </div>
            <button type="submit" class="btn btn-primary">Assign Stock</button>
        </form>
        <a href="{{ route('users.menu') }}" class="btn btn-secondary">Back to Menu</a>
    </div>
</body>
</html>
