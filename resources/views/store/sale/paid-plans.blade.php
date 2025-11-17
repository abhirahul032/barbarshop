@extends('store.layouts.app')

@section('title', 'Paid Plans List')

@section('content')
<style>
       
        
        .page-header {
            background: white;
            padding: 2rem 0 1.5rem;
            margin-bottom: 0;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #212529;
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
        
        .btn-options {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-options:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
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
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
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
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }
        
        .btn-setup {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-setup:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Paid Plans List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Paid Plans List</li>
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
                    <h1 class="page-title">Memberships sold</h1>
                    <p class="page-subtitle">View and filter memberships purchased by your clients. <a href="#">Learn more</a></p>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-options dropdown-toggle">
                        Options
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="container-fluid px-4">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-card-heading"></i>
            </div>
            <h2 class="empty-title">No memberships created yet</h2>
            <p class="empty-description">
                Add memberships in minutes and start selling<br>
                them online and via your store.
            </p>
            <button class="btn btn-setup">
                Set up now
            </button>
        </div>
    </div>
    </div>
</div>

@endsection