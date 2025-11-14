@extends('admin.layouts.app')

@section('title','Edit Business Type')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Edit Business Type</h4>
    <a href="{{ route('admin.business-type.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Display Validation Errors -->
@include('admin.layouts.error')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.business-type.update', $businessType->id) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name *</label>
                <input name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $businessType->name) }}" required />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="3">{{ old('description', $businessType->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                           {{ old('is_active', $businessType->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active
                    </label>
                </div>
            </div>

            <button class="btn btn-dark">Update Business Type</button>
            <a href="{{ route('admin.business-type.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection