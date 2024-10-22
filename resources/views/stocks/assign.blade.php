@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('css/dropdownstock.css')}}">
<script src="{{asset('js/dropdownstock.js')}}"></script>
<script src="{{asset('js/dropdownstock1.js')}}"></script>

<div class="container">
    <h1>Assign Stocks </h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($outOfStockStocks->isNotEmpty())
        <div class="alert alert-danger">
            <strong>Out of Stock:</strong>
            @foreach($outOfStockStocks as $stock)
                <p>{{ $stock->name }} (Quantity: {{ $stock->quantity }})</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('stocks.storeAssignedStocks', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="stocks">Select Stocks:</label>
            <select name="stocks[]" id="stocks" multiple class="form-control" required>
                @foreach($stocks as $stock)
                    <option value="{{ $stock->id }}">{{ $stock->name }} (Available: {{ $stock->quantity }})</option>
                @endforeach
            </select>
        </div>
</div>

<div id="selected-stocks" class="mt-3">
    <ul id="stock-list"></ul>
</div>
<div class="form-group">
    <label for="assigned_quantity">Assigned Quantity:</label>
    <input type="number" name="assigned_quantity" id="assigned_quantity" class="form-control" required>
</div>

<div class="form-group">
    <label for="is_active">Is Active:</label>
    <select name="is_active" id="is_active" class="form-control" required>
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>
</div>
<br>
<button type="submit" class="btn btn-primary">Assign Stocks</button>
<a href="{{route('stocks.index')}}" class="btn btn-danger">Back to Stock list</a>
</form>
</div>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .container {
        margin-top: 20px;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 24px;
        color: #007bff;
    }

    .alert {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: bold;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 10px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 15px;
        border-radius: 4px;
        font-size: 16px;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
<script>
    $(document).ready(function () {
        $('#stocks').select2({
            placeholder: "Select stocks",
            allowClear: true
        });
    });
</script>
@endsection