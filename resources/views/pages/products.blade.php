<!-- resources/views/products.blade.php -->

@extends('layout.layout')

@section('content')
<h1>Products</h1>
<div class="px-4">
    <div class="row justify-content-center">
        <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
            <h2 class="text-center text-success">Add Product</h2>
            <form method="POST" action="{{ route('addproduct.submit') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-row text-success">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" required value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="HScode">HScode</label>
                        <input type="text" class="form-control @error('HScode') is-invalid @enderror" id="HScode"
                            name="HScode" required value="{{ old('HScode') }}">
                        @error('HScode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row text-success">

                    <div class="form-group text-success col-md-6">
                        <label for="category_id">Category</label>
                        <select class="form-control border-success   @error('category_id') is-invalid @enderror"
                            id="category_id" name="category_id" required>
                            <!-- Populate options with categories from the database -->
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group text-success col-md-6">
                        <label for="image">Upload Image</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                            name="image">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group text-success">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-success">
                    <label for="note">Note</label>
                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                        rows="3">{{ old('note') }}</textarea>
                    @error('note')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



                <!-- Many-to-many relation with tax table -->
                <!-- THIS ONE IS NOT WITH JAVASCIPRT -->
                <div class="form-group text-success">
    <label for="taxes">Select Taxes</label>
    <select multiple class="form-control @error('taxes') is-invalid @enderror" id="taxes" name="tax_ids[]">
        @foreach ($taxes as $index => $tax)
            <option value="{{ $tax->id }}" name="tax_ids[{{ $index }}]">{{ $tax->name }}</option>
        @endforeach
    </select>
    @error('taxes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                <!-- THIS ONE IS NOT WITH JAVASCIPRT -->
                <!-- <div class="form-group">
    <label for="taxDropdown" class="form-label">Select Taxes</label>
    <select class="form-select form-control border-success" id="taxDropdown" name="tax_ids[]" multiple>
        @foreach ($taxes as $tax)
            <option value="{{ $tax->id }}">{{ $tax->name }} {{$tax->rate}}</option>
        @endforeach
    </select>

    <button type="button" class="btn btn-success mt-2 p-1" id="addTaxBtn">Add Tax</button>
    <button type="button" class="btn btn-danger mt-2 p-1" id="clearListBtn">Clear List</button>

    <div class="mt-2 text-white">
        <label for="selectedTaxes" class="form-label">Selected Taxes:</label>
        <ul id="selectedTaxesList"></ul>
        <input type="hidden" id="selectedTaxesInput" name="tax_ids[]" value="">
    </div>
</div> -->

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="border p-4 " style="background: #262329;">
    <h2 class="text-success">All Products</h2>
    @if (session('successDelete'))
    <div class="alert alert-success">
        {{ session('successDelete') }}
    </div>
    @endif

    @if ($products->isEmpty())
    <h4 class="text-danger">No Products found.</h4>
    @else
    <table class="table table-bordered text-white">
        <thead>
            <tr class="text-success">
                <th>Name</th>
                <th>HScode</th>
                <th>Category</th>
                <th>Description</th>
                <th>Note</th>
                <th>Image</th>
                <th>Taxes</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->HScode }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->note }}</td>
                @if ($product->image)
                <td><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="200" height="200" /></td>
                @else
                <td>No image</td>
                @endif
                <td>
                    @foreach ($product->taxes as $tax)
                    {{ $tax->name }}
                    @if (!$loop->last)
                    ,
                    @endif
                    @endforeach
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="Products Actions">
                        <a href="{{ route('products.getbyid', ['id' => $product->id]) }}"
                                        class="btn btn-success rounded mr-2">Edit</a>
                                        <form action="{{ route('products.delete', ['id' => $product->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var taxDropdown = document.getElementById('taxDropdown');
        var addTaxBtn = document.getElementById('addTaxBtn');
        var clearListBtn = document.getElementById('clearListBtn');
        var selectedTaxesList = document.getElementById('selectedTaxesList');
        var selectedTaxesInput = document.getElementById('selectedTaxesInput');

        addTaxBtn.addEventListener('click', function () {
            var selectedOption = taxDropdown.options[taxDropdown.selectedIndex];

            if (selectedOption) {
                var li = document.createElement('li');
                li.className = 'mt-2 mr-2';

                // Create a delete button for each tax
                var deleteBtn = document.createElement('button');
                deleteBtn.textContent = 'Delete';
                deleteBtn.className = 'btn btn-danger btn-sm ms-2 ml-2';
                deleteBtn.onclick = function () {
                    removeTax(selectedOption.value);
                };

                li.textContent = selectedOption.text;
                li.appendChild(deleteBtn);

                // Set a unique ID for each list item
                li.id = 'tax_' + selectedOption.value;

                selectedTaxesList.appendChild(li);

                var taxId = selectedOption.value;
                var currentInputValue = selectedTaxesInput.value;

                // Parse the existing value as an array
                var existingTaxIds = currentInputValue ? JSON.parse(currentInputValue) : [];

                // Add the new tax ID to the array
                existingTaxIds.push(taxId);

                // Convert the array back to JSON and set the input value
                selectedTaxesInput.value = JSON.stringify(existingTaxIds);

                selectedOption.selected = false;
            }
        });

        clearListBtn.addEventListener('click', function () {
            // Clear the entire list
            selectedTaxesList.innerHTML = '';
            // Clear the hidden input value
            selectedTaxesInput.value = '';
        });
    });

    function removeTax(taxId) {
        // Remove the specific tax from the list
        var listItem = document.getElementById('tax_' + taxId);
        if (listItem) {
            listItem.remove();

            // Remove the tax ID from the hidden input value
            var currentInputValue = selectedTaxesInput.value;

            // Parse the existing value as an array
            var existingTaxIds = currentInputValue ? JSON.parse(currentInputValue) : [];

            // Remove the tax ID from the array
            existingTaxIds = existingTaxIds.filter(function (id) {
                return id !== taxId;
            });

            // Convert the array back to JSON and set the input value
            selectedTaxesInput.value = JSON.stringify(existingTaxIds);
        }
    }
</script>

@endsection