{{-- resources/views/store/suppliers/index.blade.php --}}
@extends('store.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Suppliers</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('store.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Suppliers</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <a href="{{ route('store.suppliers.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus mr-1"></i> Add Supplier
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="card-title">Add and manage details of your suppliers. 
                                <a href="#" class="text-primary">Learn more</a>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('store.suppliers.index') }}">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Search by supplier name"
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Supplier name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Products</th>
                                    <th>Updated at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suppliers as $supplier)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center mr-2" 
                                                 style="width: 32px; height: 32px; font-size: 12px; margin-right: 10px">
                                                {{ substr($supplier->supplier_name, 0, 2) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $supplier->supplier_name }}</h6>
                                                <small class="text-muted">{{ $supplier->full_name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($supplier->mobile_number)
                                            {{ $supplier->mobile_number }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($supplier->email)
                                            {{ $supplier->email }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted">-</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $supplier->updated_at->format('d M Y h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            
                                               
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('store.suppliers.show', $supplier->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('store.suppliers.edit', $supplier->id) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                
                                                <form action="{{ route('store.suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this supplier?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                           
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-box-open fa-3x mb-3"></i>
                                            <h5>No suppliers found</h5>
                                            <p>Get started by adding your first supplier.</p>
                                            <a href="{{ route('store.suppliers.create') }}" class="btn btn-primary">
                                                Add Supplier
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($suppliers->hasPages())
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-0">
                                        Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} entries
                                    </p>
                                </div>
                                <div>
                                    {{ $suppliers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection