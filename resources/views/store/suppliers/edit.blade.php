{{-- resources/views/store/suppliers/edit.blade.php --}}
@extends('store.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Edit Supplier</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('store.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store.suppliers.index') }}">Suppliers</a></li>
                            <li class="breadcrumb-item active">Edit Supplier</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('store.suppliers.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="mb-3">Supplier details</h5>
                                
                                <div class="form-group">
                                    <label for="supplier_name">Supplier name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('supplier_name') is-invalid @enderror" 
                                           id="supplier_name" 
                                           name="supplier_name" 
                                           value="{{ old('supplier_name', $supplier->supplier_name) }}" 
                                           placeholder="e.g. L'Oreal"
                                           required>
                                    @error('supplier_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="supplier_description">Supplier description</label>
                                    <textarea class="form-control @error('supplier_description') is-invalid @enderror" 
                                              id="supplier_description" 
                                              name="supplier_description" 
                                              rows="3" 
                                              placeholder="e.g. Local provider of hair products">{{ old('supplier_description', $supplier->supplier_description) }}</textarea>
                                    @error('supplier_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3">Contact info</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First name</label>
                                            <input type="text" 
                                                   class="form-control @error('first_name') is-invalid @enderror" 
                                                   id="first_name" 
                                                   name="first_name" 
                                                   value="{{ old('first_name', $supplier->first_name) }}" 
                                                   placeholder="e.g. John">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last name</label>
                                            <input type="text" 
                                                   class="form-control @error('last_name') is-invalid @enderror" 
                                                   id="last_name" 
                                                   name="last_name" 
                                                   value="{{ old('last_name', $supplier->last_name) }}" 
                                                   placeholder="e.g. Doe">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile_number">Mobile number</label>
                                            <input type="tel" 
                                                   class="form-control @error('mobile_number') is-invalid @enderror" 
                                                   id="mobile_number" 
                                                   name="mobile_number" 
                                                   value="{{ old('mobile_number', $supplier->mobile_number) }}" 
                                                   placeholder="+91">
                                            @error('mobile_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telephone">Telephone</label>
                                            <input type="tel" 
                                                   class="form-control @error('telephone') is-invalid @enderror" 
                                                   id="telephone" 
                                                   name="telephone" 
                                                   value="{{ old('telephone', $supplier->telephone) }}" 
                                                   placeholder="+91">
                                            @error('telephone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $supplier->email) }}" 
                                                   placeholder="mail@example.com">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="website">Website</label>
                                            <input type="url" 
                                                   class="form-control @error('website') is-invalid @enderror" 
                                                   id="website" 
                                                   name="website" 
                                                   value="{{ old('website', $supplier->website) }}" 
                                                   placeholder="www.google.com">
                                            @error('website')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3">Physical address</h5>

                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input type="text" 
                                           class="form-control @error('street') is-invalid @enderror" 
                                           id="street" 
                                           name="street" 
                                           value="{{ old('street', $supplier->street) }}" 
                                           placeholder="e.g. 12 Main Street">
                                    @error('street')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="suburb">Suburb</label>
                                    <input type="text" 
                                           class="form-control @error('suburb') is-invalid @enderror" 
                                           id="suburb" 
                                           name="suburb" 
                                           value="{{ old('suburb', $supplier->suburb) }}">
                                    @error('suburb')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" 
                                                   class="form-control @error('city') is-invalid @enderror" 
                                                   id="city" 
                                                   name="city" 
                                                   value="{{ old('city', $supplier->city) }}">
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" 
                                                   class="form-control @error('state') is-invalid @enderror" 
                                                   id="state" 
                                                   name="state" 
                                                   value="{{ old('state', $supplier->state) }}">
                                            @error('state')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="postal_code">Zip / Postal Code</label>
                                            <input type="text" 
                                                   class="form-control @error('postal_code') is-invalid @enderror" 
                                                   id="postal_code" 
                                                   name="postal_code" 
                                                   value="{{ old('postal_code', $supplier->postal_code) }}">
                                            @error('postal_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <select class="form-control @error('country') is-invalid @enderror" 
                                                    id="country" 
                                                    name="country">
                                                <option value="">Select Country</option>
                                                <option value="India" {{ old('country', $supplier->country) == 'India' ? 'selected' : '' }}>India</option>
                                                <option value="United States" {{ old('country', $supplier->country) == 'United States' ? 'selected' : '' }}>United States</option>
                                                <option value="United Kingdom" {{ old('country', $supplier->country) == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                <option value="Canada" {{ old('country', $supplier->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                <option value="Australia" {{ old('country', $supplier->country) == 'Australia' ? 'selected' : '' }}>Australia</option>
                                            </select>
                                            @error('country')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="same_as_postal" 
                                               name="same_as_postal" 
                                               value="1"
                                               {{ old('same_as_postal', $supplier->same_as_postal) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="same_as_postal">
                                            Same as postal address
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">Update Supplier</button>
                                    <a href="{{ route('store.suppliers.index') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection