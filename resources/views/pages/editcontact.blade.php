<!-- resources/views/pages/editinformation.blade.php -->
@extends('layout.layout') <!-- Assuming you have a layout file -->

@section('content')
<h1>Edit Contact</h1>

<div class="px-4">
    <div class="row justify-content-center">
        <div class="col-md-6 justify-content-center border p-4" style="background: #262329;">
            <h2 class="text-center text-success">Edit Contact</h2>
            <form method="POST" action="{{ route('contacts.update', ['id' => $contact->id]) }}">
                @csrf
                @method('PATCH')
                <div class="form-row text-success">
    <div class="form-group col-md-6">
        <label for="name">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
            name="name" required value="{{ old('name', $contact->name) }}">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror"
            id="email" name="email" required value="{{ old('email', $contact->email) }}">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

                <div class="form-row text-success">
                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" required value="{{ old('phone', $contact->phone) }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address', $contact->address) }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row text-success">
                    <div class="form-group col-md-6">
                        <label for="company">Company</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" id="company"
                            name="company" required value="{{ old('company', $contact->company) }}">
                        @error('company')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="website">Website</label>
                        <input type="text" class="form-control @error('website') is-invalid @enderror" id="=website"
                            name="website" required value="{{ old('website', $contact->website) }}">
                        @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-group text-success">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="3"
                        required>{{ old('description', $contact->description) }}</textarea>
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