@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">Edit Employee</p>
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="was-validated">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="number" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="joining_date">Date of Birth</label>
                <input type="date" name="joining_date" class="form-control"
                    value="{{ old('joining_date', $employee->joining_date) }}" required>
            </div>

            <div class="form-group">
                <label for="stocks">Select Stocks:</label>
                <select name="stocks[]" id="stocks" multiple class="form-control" required>
                    @foreach($stocks as $stock)
                        <option value="{{ $stock->id }}" {{ in_array($stock->id, $employee->stocks->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $stock->name }} (Available: {{ $stock->quantity }})
                        </option>
                    @endforeach
                </select>
            </div>

            <h3>Assign Quantities</h3>
            @foreach($filteredStocks as $stock)
                <div class="form-group">
                    <label for="assigned_quantities[{{ $stock->id }}]">{{ $stock->name }}</label>
                    <input type="number" name="assigned_quantities[{{ $stock->id }}]"
                        id="assigned_quantities[{{ $stock->id }}]" class="form-control"
                        value="{{ old('assigned_quantities.' . $stock->id, $assignedQuantities[$stock->id] ?? 0) }}"
                        required min="0">
                    @error('assigned_quantities.' . $stock->id)
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            <div class="form-group">
                <label for="is_active">Is Active:</label>
                <select name="is_active" class="form-control" required>
                    <option value="1" {{ $employee->is_active ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$employee->is_active ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-success">Back</a>
        </form>
    </div>
</div>
@endsection