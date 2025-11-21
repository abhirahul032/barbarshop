@extends('admin.layouts.app')

@section('title','Edit Country')

@section('content')

<h4>Edit Country</h4>

@include('admin.layouts.error')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.countries.update', $country->id) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Country Name</label>
                <input name="name" value="{{ old('name', $country->name) }}" class="form-control" required />
            </div>

            <div class="mb-3">
                <label>ISO Code</label>
                <input name="iso_code" value="{{ old('iso_code', $country->iso_code) }}" class="form-control" maxlength="3" required />
            </div>

            <div class="mb-3">
                <label>Phone Code</label>
                <input name="phone_code" value="{{ old('phone_code', $country->phone_code) }}" class="form-control" required />
            </div>

            <button class="btn btn-dark">Update</button>
        </form>
    </div>
</div>
@endsection