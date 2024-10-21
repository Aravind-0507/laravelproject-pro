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

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<br>

<div class="row">
    <div class="col-12 d-flex justify-content-between mb-3">
        <input type="text" id="search" placeholder="Search stocks..." oninput="searchTable()" class="form-control"
            style="width: 400px;">
        <div>
            @foreach ($users as $user)
                <a href="{{ route('stocks.assign', ['user' => $user->id]) }}" class="btn btn-primary mx-1">Assign Stocks</a>
            @endforeach
        </div>
    </div>
</div>
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
                    <tbody id="stocksTableBody">
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
                <div class="d-flex justify-content-end align-items-center mt-3">
                    <div id="pagination" class="pagination"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const rowsPerPage = 6;
        let currentPage = 1;

        function searchTable() {
            const input = document.getElementById("search").value.toLowerCase();
            const rows = document.querySelectorAll("#stocksTableBody tr");
            let filteredRows = [];

            rows.forEach((row) => {
                const name = row.cells[1].innerText.toLowerCase();
                const quantity = row.cells[2].innerText.toLowerCase();

                if (name.includes(input) || quantity.includes(input)) {
                    filteredRows.push(row);
                }
            });
            paginate(filteredRows);
        }

        function paginate(filteredRows) {
            const paginationDiv = document.getElementById("pagination");
            paginationDiv.innerHTML = "";
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const visibleRows = filteredRows.slice(start, end);
            document.querySelectorAll("#stocksTableBody tr").forEach(row => {
                row.style.display = "none";
            });
            visibleRows.forEach(row => {
                row.style.display = "";
            });
            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement("button");
                button.innerText = i;
                button.classList.add("btn", "btn-secondary", "mx-1");
                button.onclick = function () {
                    currentPage = i;
                    paginate(filteredRows);
                };
                paginationDiv.appendChild(button);
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            paginate(Array.from(document.querySelectorAll("#stocksTableBody tr")));
        });
    </script>

    @endsection