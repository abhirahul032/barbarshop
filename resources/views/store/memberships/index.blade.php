{{-- resources/views/store/memberships/index.blade.php --}}
@extends('store.layouts.app')

@section('title', 'Memberships')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('store.memberships.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> Create Membership
                    </a>
                </div>
                <h4 class="page-title">Memberships</h4>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($memberships as $membership)
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="card-title">{{ $membership->name }}</h4>
                            <p class="text-muted mb-2">{{ Str::limit($membership->description, 100) }}</p>
                        </div>
                        <span class="badge bg-{{ $membership->is_active ? 'success' : 'secondary' }}">
                            {{ $membership->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center text-muted mb-1">
                            <i class="fa fa-tag me-2"></i>
                            <span>${{ number_format($membership->price, 2) }}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted mb-1">
                            <i class="fa fa-calendar me-2"></i>
                            <span>Valid for {{ $membership->validity_duration }} {{ str($membership->validity_period)->plural() }}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted">
                            <i class="fa fa-clock me-2"></i>
                            <span>
                                @if($membership->session_type === 'unlimited')
                                    Unlimited sessions
                                @else
                                    {{ $membership->session_count }} sessions
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="btn-group">
                            <a href="{{ route('store.memberships.show', $membership) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('store.memberships.edit', $membership) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('store.memberships.toggle-status', $membership) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-outline-{{ $membership->is_active ? 'warning' : 'success' }}">
                                    <i class="fa fa-{{ $membership->is_active ? 'pause' : 'play' }}"></i>
                                </button>
                            </form>
                        </div>
                        <form action="{{ route('store.memberships.destroy', $membership) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if($memberships->isEmpty())
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fa fa-gem fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Memberships Yet</h4>
                    <p class="text-muted">Create your first membership to offer package deals to your clients.</p>
                    <a href="{{ route('store.memberships.create') }}" class="btn btn-primary">
                        Create Membership
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection