<!-- resources/views/hi.blade.php -->

@extends('layout.layout')

@section('content')
<!-- <div class="container"> -->
<!-- Your home page content goes here -->
<h1>Informations</h1>
<div class="   px-4">
    <div class="row  justify-content-center">
        <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
            <h2 class="text-center text-success">Add Information</h2>
            <form method="POST" action="{{ route('addinformation.submit') }}">
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
    <h2 class="text-success">All Informations</h2>
    @if(session('successDelete'))
    <div class="alert alert-success">
        {{ session('successDelete') }}
    </div>
    @endif


    @if($informations->isEmpty())
    <h4 class="text-danger">No Informations found.</h4>
    @else
    <table class="table table-bordered text-white">
        <thead>
            <tr class="text-success">
                <th>id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status </th>
            </tr>
        </thead>
        <tbody>
            @foreach($informations as $information)
            <tr>
                <td>{{ $information->id }}</td>

                <td>{{ $information->name }}</td>
                <td>{{ $information->description }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Infromations Actions">

                    <a href="{{ route('informations.getbyid', ['id' => $information->id]) }}" class="btn btn-success rounded mr-2">Edit</a>



                        <form action="{{ route('informations.delete', ['id' => $information->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this information?')">
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