@extends('admin.layouts.app')

@section('title','Edit Package')

@section('content')

<h4>Edit Package</h4>

@include('admin.layouts.error')
<div class="card">
    <div class="card-body">
<form method="POST" action="{{ route('admin.package.update', $package->id) }}">
    @csrf @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input name="name" value="{{ $package->name }}" class="form-control" required />
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input name="price" type="number" value="{{ $package->price }}" class="form-control" required />
    </div>

    <div class="mb-3">
        <label>Duration (days)</label>
        <input name="duration" type="number" value="{{ $package->duration }}" class="form-control" required />
    </div>

    <button class="btn btn-dark">Update</button>
</form>
</div></div>
@endsection
