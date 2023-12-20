<!-- resources/views/hi.blade.php -->

@extends('layout.layout')

@section('content')
<!-- <div class="container"> -->
<!-- Your home page content goes here -->
<h1>Categories</h1>
<div class="   px-4">
    <div class="row  justify-content-center">
        <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
            <h2 class="text-center text-success">Add Category</h2>
            <form method="POST" action="{{ route('addcategory.submit') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group w-full">
                    <label for="name " class="text-success">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        required value="{{ old('name') }}">
                    @error('name')
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

                <div class="form-group text-success">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



                @if(session('success'))
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
    <h2 class="text-success">All Categories</h2>

    @if(session('successDelete'))
    <div class="alert alert-success">
        {{ session('successDelete') }}
    </div>
    @endif
    @if(session('errorRelation'))
    <div class="alert alert-warning">
        {{ session('errorRelation') }}
    </div>
    @endif
    @if($categories->isEmpty())
    <h4 class="text-danger">No Categories found.</h4>
    @else
    <table class="table table-bordered text-white">
        <thead>
            <tr class="text-success">
                <th>id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                @if($category->image)
                <td><img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="200" heigth="200" />
                </td>
                @endif
                <td>
                    <div class="btn-group" role="group" aria-label="Categories Actions">
                    <a href="{{ route('categories.getbyid', ['id' => $category->id]) }}" class="btn btn-success rounded mr-2">Edit</a>
                        <form action="{{ route('categories.delete', ['id' => $category->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this Category?')">
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
<!-- </div> -->
@endsection