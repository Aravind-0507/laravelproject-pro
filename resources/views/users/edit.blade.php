@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">Edit User</p>
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="was-validated">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="number" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
            </div>

            <div class="form-group">
                <label for="joining_date">Date of Birth</label>
                <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', $user->joining_date) }}" required>
            </div>

            <div class="form-group">
                <label for="stocks">Select Stocks:</label>
                <select name="stocks[]" id="stocks" multiple class="form-control" required>
                    @foreach ($stocks as $stock)
                    <option value="{{ $stock->id }}" 
                    {{ in_array($stock->id, $user->stocks->pluck('id')->toArray()) ? 'selected' : '' }} 
                    {{ $stock->quantity <= 0 ? 'disabled' : '' }}>
                    {{ $stock->name }} (Available: {{ $stock->quantity }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div id="assigned-quantities">
                <p>Assigned Quantities:</p>
                @foreach ($user->stocks as $stock)
                    <div class="form-group">
                        <label for="assigned_quantity_{{ $stock->id }}">{{ $stock->name }}</label>
                        <input type="number" name="assigned_quantities[]" id="assigned_quantity_{{ $stock->id }}"
                        class="form-control"
                        value="{{ old('assigned_quantities.' . $loop->index, $stock->pivot->assigned_quantity) }}"
                        required min="0">
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label for="is_active">Is Active:</label>
                <select name="is_active" class="form-control" required>
                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('users.index') }}" class="btn btn-success">Back</a>
        </form>
    </div>
</div>
@endsection
