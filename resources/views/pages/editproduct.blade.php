@extends('layout.layout') <!-- Assuming you have a layout file -->

@section('content')

<h1>Edit Product</h1>
<div class="px-4">
    <div class="row justify-content-center">
        <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
            <h2 class="text-center text-success">Edit Category</h2>
            <form method="POST" action="{{ route('products.update', ['id' => $product->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-row text-success">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" required value="{{ old('name', $product->name) }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="HScode">HScode</label>
                        <input type="text" class="form-control @error('HScode') is-invalid @enderror" id="HScode"
                            name="HScode" required value="{{ old('HScode', $product->HScode) }}">
                        @error('HScode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row text-success">

                    <div class="form-group text-success col-md-6">
                        <label for="category_id">Category</label>
                        <select class="form-control border-success @error('category_id') is-invalid @enderror"
                            id="category_id" name="category_id" required>
                            <!-- Populate options with categories from the database -->
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) ==
                                $category->id) selected @endif>{{ $category->name }}</option>
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
                        name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-success">
                    <label for="note">Note</label>
                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                        rows="3">{{ old('note', $product->note) }}</textarea>
                    @error('note')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-success">
                    <label for="taxes">Select Taxes</label>
                    <select multiple class="form-control @error('taxes') is-invalid @enderror" id="taxes"
                        name="tax_ids[]">
                        @foreach ($taxes as $tax)
                        <option value="{{ $tax->id }}" {{ in_array($tax->id, $product->taxes->pluck('id')->toArray()) ?
                            'selected' : '' }}>{{ $tax->name }}</option>
                        @endforeach
                    </select>
                    @error('taxes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Update</button>

                @endsection