@extends('layouts.app')

@section('content')

<div class="sidenav">
    <a href="{{ route('employees.index') }}">Users List</a><br>
    <a href="{{ route('stocks.index') }}">Stock</a>
    

</div>

<style>
    body {
        font-family: Arial, sans-serif;
    }

    .sidenav {
        height: 100%;
        width: 200px;
        position: fixed;
        top: 60px;
        left: 0;
        background-color: #111;
        padding-top: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        overflow-y: auto;
    }

    .sidenav a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 18px;
        color: #f8f9fa;
        display: block;
        transition: background-color 0.3s;
    }

    .sidenav a:hover {
        background-color: blue;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    h1 {
        margin-bottom: 20px;
        text-align: center;
    }

    .alert {
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 5px;
        background-color: #e2f0d9;
        color: #3c763d;
        text-align: center;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    .table thead {
        background-color: #f8f9fa;
    }

    .table th,
    .table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    .btn {
        padding: 8px 12px;
        text-decoration: none;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-primary:hover,
    .btn-danger:hover,
    .btn-success:hover {
        opacity: 0.8;
    }

    @media (max-width: 768px) {

        .table,
        .table th,
        .table td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .table thead {
            display: none;
        }

        .table tr {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .table td {
            text-align: left;
            padding: 10px;
            position: relative;
        }

        .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            top: 10px;
            font-weight: bold;
            color: #007bff;
        }
    }
</style>

<h1>Stocks</h1>

<div class="text-center">
    <a href="{{ route('stocks.create') }}" class="btn btn-success">Add Stock</a>
</div>
@foreach ($users as $user)
        <td>
            <a href="{{ route('stocks.assign', ['user' => $user->id]) }}" class="btn btn-primary">Assign Stocks</a>
        </td>
@endforeach
<br>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <strong>Stocks List</strong>
                <table class="table table-bordered table-striped" style="margin-top:10px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stocks as $stock)
                            <tr>
                                <td>{{ $stock->id }}</td>
                                <td>{{ $stock->name }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>
                                    <span class="btn {{ $stock->status == 'active' ? 'btn-success' : 'btn-danger' }}">
                                        {{ $stock->status == 'active' ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('stocks.edit', $stock->id) }}"
                                        class="btn btn-primary btn-sm mx-2">Edit</a>
                                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this stock?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection