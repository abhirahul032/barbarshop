@extends('admin.layouts.app')

@section('title','Create Package')

@section('content')

<h4>Create Package</h4>
@include('admin.layouts.error')
<div class="card">
    <div class="card-body">
<form method="POST" action="{{ route('admin.package.store') }}">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input name="name" class="form-control" required />
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input name="price" type="number" class="form-control" required />
    </div>

    <div class="mb-3">
        <label>Duration (days)</label>
        <input name="duration" type="number" class="form-control" required />
    </div>

    <button class="btn btn-dark">Save</button>
</form></div></div>

@endsection
