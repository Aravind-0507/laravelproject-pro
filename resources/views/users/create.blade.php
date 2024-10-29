@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dropdownstock.css') }}">
<script src="{{ asset('js/dropdownstock.js') }}"></script>
<script src="{{ asset('js/dropdownstock1.js') }}"></script>

<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">Create New User</p>
        <form action="{{ route('users.store') }}" class="was-validated" method="POST" novalidate>
            @csrf

            <div class="form-group has-validation">
                <label for="name">Name</label>
                <input type="text" name="name" id="name"
                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required
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
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" required
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
                    class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" required
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
                    class="form-control {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" required
                    value="{{ old('joining_date') }}">
                @if($errors->has('joining_date'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('joining_date') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="stocks">Select Stocks:</label>
                <div id="stock-quantity-container">
                    <div class="d-flex align-items-center mb-2">
                        <select name="stocks[]" class="form-control me-2 @error('stocks') is-invalid @enderror"
                            required>
                            <option value="" disabled selected>Select Stock</option>
                            @foreach($stocks as $stock)
                                <option value="{{ $stock->id }}">{{ $stock->name }} (Available: {{ $stock->quantity }})
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="assigned_quantities[]"
                            class="form-control me-2 @error('assigned_quantities') is-invalid @enderror" required
                            placeholder="Quantity">
                        <button type="button" class="btn btn-danger" onclick="removeStockRow(this)">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-stock" class="btn btn-secondary mt-2" onclick="addStockRow()">Add Another
                    Stock</button>
                @error('stocks')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group has-validation">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                @if($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-validation">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" required>
                @if($errors->has('confirm_password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('confirm_password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-validation">
                <label for="is_active">Is Active:</label>
                <select name="is_active" id="is_active" class="form-control" required>
                    <option value="" disabled selected>Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                @if($errors->has('is_active'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('is_active') }}</strong>
                    </span>
                @endif
            </div>
            <div>

            </div>
            <br>
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('users.index') }}" class="btn btn-success">Back</a>
        </form>
    </div>
</div>

<script>
    document.getElementById('add-quantity').addEventListener('click', function () {
        const container = document.getElementById('assigned-quantities-container');
        const index = container.querySelectorAll('input[type="number"]').length;
        const input = document.createElement('input');
        input.type = 'number';
        input.name = `assigned_quantities[${index}]`;
        input.className = 'form-control mt-2';
        input.placeholder = `Enter quantity for selected stock ${index + 1}`;
        container.appendChild(input);
    });
</script>

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
@endsection