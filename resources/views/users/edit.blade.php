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
                <input type="number" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="joining_date">Date of Birth</label>
                <input type="date" name="joining_date" class="form-control"
                    value="{{ old('joining_date', $user->joining_date) }}" required>
            </div>

            <div class="form-group">
                <label for="stocks">Assigned Stocks:</label>
                <div id="stock-quantity-container">
                    @foreach($user->stocks as $stock)
                        <div class="d-flex align-items-center mb-2">
                            <select name="stocks[]" class="form-control me-2" required>
                                <option value="{{ $stock->id }}" selected>{{ $stock->name }}</option>
                                @foreach($stocks as $availableStock)
                                    <option value="{{ $availableStock->id }}">{{ $availableStock->name }} (Available:
                                        {{ $availableStock->quantity }})</option>
                                @endforeach
                            </select>
                            <input type="number" name="assigned_quantities[]" class="form-control me-2"
                                value="{{ $stock->pivot->assigned_quantity }}" required>
                            <button type="button" class="btn btn-danger" onclick="removeStockRow(this)">Remove</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-stock" class="btn btn-secondary mt-2" onclick="addStockRow()">Add Another
                    Stock</button>
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

    function removeStockRow(button) {
        button.parentElement.remove();
    }
</script>

@endsection