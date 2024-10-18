@extends('layouts.app')

@section('content')

<div class="sidenav">
    <a href="{{ route('employees.index') }}">Users List</a>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<header>
    <nav>
        <h2 style="margin: 0;">Welcome!</h2>
        <div class="profile-icon" style="position: relative;">
            <i class="fas fa-user-circle" id="profile-icon" style="font-size: 30px; cursor: pointer;"> </i>
            <div class="dropdown" id="dropdown-menu">
                <a href="{{ route('profile.edit') }}">Update</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                </form>
            </div>
        </div>
    </nav>
</header>

<div id="main" style="flex-grow: 1; padding: 20px; margin-left: 220px; margin-top: 60px;">
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center" id="searchBarContainer">
        <div class="col-md-8">
            <input type="text" id="search" class="form-control mb-3" placeholder="Search by name or email..."
                onkeyup="searchTable()">
        </div>
        <a href="{{ route('export.excel') }}" class="btn btn-success ms-3">Export to CSV</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <strong>Users List</strong>
                    <a href="{{ route('employees.create') }}" class="btn btn-primary btn-xs float-end py-0">Create
                        User</a>
                    <table class="table table-responsive table-bordered table-striped" id="employeeTable"
                        style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date of Birth</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTableBody">
                            @foreach($employees as $key => $employee)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->joining_date }}</td>
                                    <td>
                                        <span
                                            class="btn {{ $employee->is_active == 1 ? 'btn-success' : 'btn-danger' }} btn-xs py-0">
                                            {{ $employee->is_active == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-inline">
                                            <a href="{{ route('employees.show', $employee->id) }}"
                                                class="btn btn-primary btn-sm mx-2">Show</a>
                                            <a href="{{ route('employees.edit', $employee->id) }}"
                                                class="btn btn-warning btn-sm mx-2">Edit</a>
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this User?');"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mx-1">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div id="pagination" class="pagination ms-auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const rowsPerPage = 10;
    let currentPage = 1;

    function searchTable() {
        const input = document.getElementById("search").value.toLowerCase();
        const rows = document.querySelectorAll("#employeeTableBody tr");
        let filteredRows = [];

        rows.forEach((row) => {
            const name = row.cells[1].innerText.toLowerCase();
            const email = row.cells[2].innerText.toLowerCase();

            if (name.includes(input) || email.includes(input)) {
                row.style.display = "";
                filteredRows.push(row);
            } else {
                row.style.display = "none";
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
        document.querySelectorAll("#employeeTableBody tr").forEach(row => {
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
        searchTable();
    });

    document.querySelector('.profile-dropdown').addEventListener('click', function () {
        const dropdownMenu = this.querySelector('.dropdown-menu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function (event) {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        if (!event.target.matches('.profile-dropdown') && dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        }
    });
</script>

<style>
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

    nav {
        color: white;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .profile-icon {
        position: relative;
        margin-left: 20px;
    }

    .dropdown {
        display: none;
        position: absolute;
        left: 0;
        top: 40px;
        background-color: white;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown a:hover {
        background-color: #f1f1f1;
    }
</style>

<script>
    document.getElementById('profile-icon').addEventListener('click', function () {
        const dropdownMenu = document.getElementById('dropdown-menu');

        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function (event) {
        const dropdownMenu = document.getElementById('dropdown-menu');
        if (!event.target.matches('#profile-icon') && dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        }
    });
</script>
@endsection