@extends('store.layouts.app')

@section('title', 'Suppliers')

@section('content')
 <style>
     
        
        .page-header {
            background: white;
            padding: 2rem 0 1.5rem;
            margin-bottom: 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #212529;
        }
        
        .page-title .badge {
            font-size: 1rem;
            font-weight: 400;
            background: transparent;
            color: #6c757d;
            padding: 0;
            margin-left: 0.5rem;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        .page-subtitle a {
            color: #6366f1;
            text-decoration: none;
        }
        
        .page-subtitle a:hover {
            text-decoration: underline;
        }
        
        .btn-add {
            background: #212529;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
        }
        
        .btn-add:hover {
            background: #000;
            color: white;
        }
        
        .empty-state {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 6rem 2rem;
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .empty-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.5rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .truck-icon {
            font-size: 48px;
            color: #c084fc;
        }
        
        .empty-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        
        .empty-description {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .empty-description a {
            color: #6366f1;
            text-decoration: none;
        }
        
        .empty-description a:hover {
            text-decoration: underline;
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Suppliers</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Suppliers</li>
                </ol>
            </div>

        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
            <div class="page-header">
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-md-10">
                    <h1 class="page-title">
                        Suppliers
                        <span class="badge">0</span>
                    </h1>
                    <p class="page-subtitle">Add and manage details of your suppliers. <a href="#">Learn more</a></p>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-add">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="container-fluid px-4">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-truck truck-icon"></i>
            </div>
            <h2 class="empty-title">No suppliers yet</h2>
            <p class="empty-description">
                <a href="#">Click here</a> to add a supplier now.
            </p>
        </div>
    </div>
    </div>
</div>

@endsection