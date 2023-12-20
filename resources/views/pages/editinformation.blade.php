<!-- resources/views/pages/editinformation.blade.php -->
@extends('layout.layout') <!-- Assuming you have a layout file -->

@section('content')
    <h1>Edit Information</h1>

    <div class="px-4">
        <div class="row justify-content-center">
            <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
                <h2 class="text-center text-success">Edit Information</h2>
                <form method="POST" action="{{ route('informations.update', ['id' => $information->id]) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group w-full">
                        <label for="name" class="text-success">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" required value="{{ old('name', $information->name) }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-success">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="3" required>{{ old('description', $information->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
