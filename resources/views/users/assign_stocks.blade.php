<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Stocks</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('css/myfile.css')}}"></link>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
        }

        .form-group {
            margin: 20px 0;
        }

        .d-flex {
            display: flex;
            align-items: center;
        }

        .form-control {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
        }

        .me-2 {
            margin-right: 10px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Assign Stocks to User</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('users.store_stock', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="stocks">Assigned Stocks:</label>
            <div id="stock-quantity-container"></div>
            <button type="button" id="add-stock" class="btn btn-secondary mt-2" onclick="addStockRow()">Add Another Stock</button>
        </div>

        <button type="submit" class="btn btn-primary">Assign Stock</button>
        <br><br>
        <a href="{{route('users.menu')}}" class="btn btn-success">Back to User Stock </a>
    </form>
</div>

<script>
    function addStockRow() {
        const stockQuantityContainer = document.getElementById('stock-quantity-container');
        const newRow = document.createElement('div');
        newRow.className = 'd-flex align-items-center mb-2';

        const newStockSelect = document.createElement('select');
        newStockSelect.name = 'stocks[]';
        newStockSelect.className = 'form-control me-2';
        newStockSelect.required = true;
        newStockSelect.innerHTML = `
            <option value="" disabled selected>Select Stock</option>
            @foreach($stocks as $stock)
                <option value="{{ $stock->id }}">{{ $stock->name }} (Available: {{ $stock->quantity }})</option>
            @endforeach
        `;

        const newQuantityInput = document.createElement('input');
        newQuantityInput.type = 'number';
        newQuantityInput.name = 'assigned_quantities[]';
        newQuantityInput.className = 'form-control me-2';
        newQuantityInput.required = true;
        newQuantityInput.placeholder = 'Quantity';

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger';
        removeButton.innerText = 'Remove';
        removeButton.onclick = () => newRow.remove();

        newRow.appendChild(newStockSelect);
        newRow.appendChild(newQuantityInput);
        newRow.appendChild(removeButton);
        stockQuantityContainer.appendChild(newRow);
    }
</script>
</body>
</html>
