@extends('admin.layouts.app')

@section('title','Create Country')

@section('content')

<h4>Create Country</h4>
@include('admin.layouts.error')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.countries.store') }}">
            @csrf

            <div class="mb-3">
                <label>Country Name</label>
                <input name="name" class="form-control" value="{{ old('name') }}" required />
            </div>

            <div class="mb-3">
                <label>ISO Code</label>
                <input name="iso_code" class="form-control" value="{{ old('iso_code') }}" maxlength="3" required />
            </div>

            <div class="mb-3">
                <label>Phone Code</label>
                <input name="phone_code" class="form-control" value="{{ old('phone_code') }}" required />
            </div>

            <button class="btn btn-dark">Save</button>
        </form>
    </div>
</div>

@endsection