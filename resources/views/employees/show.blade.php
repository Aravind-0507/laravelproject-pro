@extends('layouts.app')
@section('content')

<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">User details</p>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" value="{{$employee->name}}" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" value="{{$employee->email}}" readonly>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="number" class="form-control" value="{{$employee->phone}}" readonly>
        </div>

        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                value="{{ $employee->joining_date}}" readonly>
        </div>
        <div class="form-group">
            <label for="is_active">Active</label><br>
            <input type="checkbox" {{$employee->is_active == '1' ? 'checked' : ''}} readonly />
        </div>
        <a href="{{route('employees.index')}}" class="btn btn-primary">Back</a>
    </div>
</div>
</div>
@endsection