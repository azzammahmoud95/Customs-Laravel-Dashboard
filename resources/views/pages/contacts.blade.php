<!-- resources/views/hi.blade.php -->

@extends('layout.layout')

@section('content')
<!-- <div class="container"> -->
<!-- Your home page content goes here -->
<h1>Contacts</h1>
<div class="   px-4">
    <div class="row  justify-content-center">
        <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
            <h2 class="text-center text-success">Add Contact</h2>
            <form method="POST" action="{{ route('addcontact.submit') }}">
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
                        <label for="company_email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" required value="{{ old('email') }}">
                        @error('company_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row text-success">
                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" required value="{{ old('phone') }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" required value="{{ old('address') }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                
                <div class="form-row text-success">
                    <div class="form-group col-md-6">
                        <label for="company">Company</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" id="company"
                            name="company" required value="{{ old('company') }}">
                        @error('company')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="website">Website</label>
                        <input type="text" class="form-control @error('website') is-invalid @enderror" id="=website"
                            name="website" required value="{{ old('website') }}">
                        @error('website')
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
        <h2 class="text-success">All Contacts</h2>
        @if(session('successDelete'))
    <div class="alert alert-success">
        {{ session('successDelete') }}
    </div>
    @endif
     

        @if($contacts->isEmpty())
        <h4 class="text-danger">No Contacts found.</h4>
        @else
            <table class="table table-bordered text-white">
                <thead>
                    <tr class="text-success">
                        <th>Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Description</th>
                        <th>Website</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->company }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->address }}</td>
                            <td>{{ $contact->description }}</td>
                            <td>{{ $contact->website }}</td>
                            <td>
                    <div class="btn-group" role="group" aria-label="Roles Actions">
                        <a href="{{ route('contacts.getbyid', ['id' => $contact->id]) }}" class="btn btn-success rounded mr-2   ">Edit</a>
                        <form action="{{ route('contacts.delete', ['id' => $contact->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this Contact?')">
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