<!-- resources/views/pages/editinformation.blade.php -->
@extends('layout.layout') <!-- Assuming you have a layout file -->

@section('content')
<h1>Edit Tax</h1>

<div class="px-4">
    <div class="row justify-content-center">
        <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
            <h2 class="text-center text-success">Edit Tax</h2>
            <form method="POST" action="{{ route('taxes.update', ['id' => $tax->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-group w-full">
                    <label for="name" class="text-success">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        required value="{{ old('name', $tax->name) }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group w-full">
                    <label for="rate " class="text-success">rate</label>
                    <input type="number" class="form-control @error('rate') is-invalid @enderror" id="rate" name="rate"
                        required value="{{ old('rate', $tax->rate) }}">
                    @error('rate')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group text-success">
                    <label for="image">Upload Image</label>
                    <input type="file" value="{{ old('image') }}"
                        class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection