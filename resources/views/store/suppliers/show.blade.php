{{-- resources/views/store/suppliers/show.blade.php --}}
@extends('store.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Supplier Details</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('store.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('store.suppliers.index') }}">Suppliers</a></li>
                            <li class="breadcrumb-item active">Supplier Details</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <a href="{{ route('store.suppliers.edit', $supplier->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit mr-1"></i> Edit Supplier
                            </a>
                            <a href="{{ route('store.suppliers.index') }}" class="btn btn-light btn-sm">
                                <i class="fa fa-arrow-left mr-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center mr-3" 
                                         style="width: 60px; height: 60px; font-size: 18px;">
                                        {{ substr($supplier->supplier_name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h3 class="mb-0">{{ $supplier->supplier_name }}</h3>
                                        <p class="text-muted mb-0">{{ $supplier->supplier_code }}</p>
                                    </div>
                                </div>
                                
                                @if($supplier->supplier_description)
                                <p class="text-muted">{{ $supplier->supplier_description }}</p>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Contact Information</h5>
                                    <div class="mb-3">
                                        <strong>Contact Person:</strong><br>
                                        {{ $supplier->full_name ?: 'Not specified' }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Mobile:</strong><br>
                                        {{ $supplier->mobile_number ?: 'Not specified' }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Telephone:</strong><br>
                                        {{ $supplier->telephone ?: 'Not specified' }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Email:</strong><br>
                                        {{ $supplier->email ?: 'Not specified' }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Website:</strong><br>
                                        {{ $supplier->website ?: 'Not specified' }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="mb-3">Address</h5>
                                    @if($supplier->street || $supplier->city || $supplier->country)
                                    <div class="mb-3">
                                        <strong>Address:</strong><br>
                                        {!! nl2br(e($supplier->full_address)) ?: 'Not specified' !!}
                                    </div>
                                    @else
                                    <p class="text-muted">No address information available.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">
                                                Created: {{ $supplier->created_at->format('M d, Y h:i A') }}
                                            </small>
                                        </div>
                                        <div>
                                            <small class="text-muted">
                                                Last Updated: {{ $supplier->updated_at->format('M d, Y h:i A') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection