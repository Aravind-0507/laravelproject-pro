@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h5 style="font-size:20px; font-weight:bold;">User Details</h5>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" value="{{ $user->email }}" readonly>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" value="{{ $user->phone }}" readonly>
        </div>

        <div class="form-group">
            <label for="joining_date">Date of Birth:</label>
            <input type="date" class="form-control" value="{{ $user->joining_date }}" readonly>
        </div>

        <div class="form-group">
            <label for="is_active">Is Active:</label>
            <input type="text" class="form-control" value="{{ $user->is_active ? 'Yes' : 'No' }}" readonly>
        </div>

        <div class="form-group">
            <label for="stocks">Assigned Stocks:</label>
            <ul>
                @foreach($user->stocks as $stock)
                    <li>
                        <strong>{{ $stock->name }}</strong>
                        <div class="form-group">
                            <label for="assigned_quantity_{{ $stock->id }}">Assigned Quantity:</label>
                            <input type="number" id="assigned_quantity_{{ $stock->id }}" class="form-control"
                            value="{{ $stock->pivot->assigned_quantity }}" readonly>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-success">Back</a>
    </div>
</div>

@endsection