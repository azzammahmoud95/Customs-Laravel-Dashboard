<!-- resources/views/hi.blade.php -->

@extends('layout.layout')

@section('content')
<!-- <div class="container"> -->
<!-- Your home page content goes here -->
<h1>Taxes</h1>
<div class="   px-4">
    <div class="row  justify-content-center">
        <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
            <h2 class="text-center text-success">Add Tax</h2>
            <form method="POST" action="{{ route('addtax.submit') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group w-full">
                    <label for="name " class="text-success">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        required value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group w-full">
                    <label for="rate " class="text-success">rate</label>
                    <input type="number" class="form-control @error('rate') is-invalid @enderror" id="rate" name="rate"
                        required value="{{ old('rate') }}">
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
    <h2 class="text-success">All Taxes</h2>

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
    @if($taxes->isEmpty())
    <h4 class="text-danger">No Taxes found.</h4>
    @else
    <table class="table table-bordered text-white">
        <thead>
            <tr class="text-success">
                <th>id</th>
                <th>Name</th>
                <th>rate</th>
                <th>Image</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            @foreach($taxes as $tax)
            <tr>
                <td>{{ $tax->id }}</td>
                <td>{{ $tax->name }}</td>
                <td>{{ $tax->rate }}</td>
                @if($tax->image)
                <td><img src="{{ asset($tax->image) }}" alt="{{ $tax->name }}" width="200" heigth="200" /></td>
                @endif
                <td>
                    <div class="btn-group" role="group" aria-label="Taxes Actions">
                    <a href="{{ route('taxes.getbyid', ['id' => $tax->id]) }}" class="btn btn-success rounded mr-2">Edit</a>
                        <form action="{{ route('taxes.delete', ['id' => $tax->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this Tax?')">
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