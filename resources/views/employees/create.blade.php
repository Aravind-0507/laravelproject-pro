@extends('layouts.app')
@section('content')

<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">Create New User</p>
        <form action="{{ route('employees.store') }}" class="was-validated" method="POST" novalidate>
            @csrf
            <div class="form-group has-validation">
                <label for="name">Name</label>
                <input type="text" name="name" id="name"
                    class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" required
                    value="{{ old('name') }}">
                @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-validation">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" required
                    value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-validation">
                <label for="phone">Phone</label>
                <input type="number" name="phone" id="phone"
                    class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" required
                    value="{{ old('phone') }}">
                @if($errors->has('phone'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-validation">
                <label for="joining_date">Date of Birth</label>
                <input type="date" name="joining_date" id="joining_date"
                    class="form-control {{$errors->has('joining_date') ? 'is-invalid' : ''}}" required
                    value="{{ old('joining_date') }}">
                @if($errors->has('joining_date'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('joining_date') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-validation">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"
                    class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" required>
                @if($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-validation">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    class="form-control {{$errors->has('confirm_password') ? 'is-invalid' : ''}}" required>
                @if($errors->has('confirm_password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('confirm_password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-validation">
                <label for="is_active">Active</label><br>
                <input type="checkbox" name="is_active" id="is_active"
                    class="{{$errors->has('is_active') ? 'is-invalid' : ''}}" value="1" {{ old('is_active') == '1' ? 'checked' : '' }}> <!--so here we can use the ternary operator-->
                @if($errors->has('is_active'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('is_active') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('employees.index') }}" class="btn btn-success">Back</a>
        </form>
    </div>
</div>
@endsection