<!-- resources/views/pages/editinformation.blade.php -->
@extends('layout.layout') <!-- Assuming you have a layout file -->

@section('content')
    <h1>Edit Role</h1>

    <div class="px-4">
        <div class="row justify-content-center">
            <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
                <h2 class="text-center text-success">Edit Role</h2>
                <form method="POST" action="{{ route('roles.update', ['id' => $role->id]) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group w-full">
                        <label for="name" class="text-success">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" required value="{{ old('name', $role->name) }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
