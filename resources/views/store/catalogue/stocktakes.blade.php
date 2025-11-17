@extends('store.layouts.app')

@section('title', 'Stock takes')

@section('content')
 <style>
      
       
        
        .content-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .free-badge {
            display: inline-block;
            background: #dcfce7;
            color: #16a34a;
            font-weight: 600;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        
        .main-heading {
            font-size: 3rem;
            font-weight: 700;
            color: #212529;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        
        .main-description {
            font-size: 1.125rem;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .features-list {
            list-style: none;
            padding: 0;
            margin-bottom: 2.5rem;
        }
        
        .features-list li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            color: #374151;
            font-size: 1rem;
            line-height: 1.6;
        }
        
        .check-icon {
            color: #10b981;
            font-size: 1.25rem;
            margin-right: 0.75rem;
            flex-shrink: 0;
            margin-top: 0.125rem;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn-start {
            background: #212529;
            color: white;
            padding: 0.875rem 2.5rem;
            border-radius: 24px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .btn-start:hover {
            background: #000;
            color: white;
        }
        
        .btn-learn {
            background: transparent;
            color: #212529;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.875rem 1.5rem;
        }
        
        .btn-learn:hover {
            text-decoration: underline;
        }
        
        .stock-visual {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }
        
        .stock-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .stock-title {
            font-weight: 600;
            color: #212529;
            font-size: 1.125rem;
        }
        
        .filter-icon {
            color: #6b7280;
            font-size: 1.125rem;
            cursor: pointer;
        }
        
        .stock-section {
            margin-bottom: 1.5rem;
        }
        
        .product-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 0.75rem;
        }
        
        .product-icon {
            width: 50px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            flex-shrink: 0;
        }
        
        .bottle-pink {
            background: linear-gradient(135deg, #f9a8d4 0%, #f472b6 100%);
        }
        
        .bottle-yellow {
            background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
        }
        
        .bottle-purple {
            background: linear-gradient(135deg, #d8b4fe 0%, #c084fc 100%);
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-name {
            font-weight: 500;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        
        .stock-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.625rem;
            border-radius: 4px;
        }
        
        .badge-purple {
            background: #ede9fe;
            color: #7c3aed;
        }
        
        .badge-yellow {
            background: #fef3c7;
            color: #d97706;
        }
        
        .badge-red {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .section-divider {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.875rem;
            margin: 1.5rem 0 1rem;
        }
        
        .stock-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f3f5;
        }
        
        .btn-control {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #6366f1;
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        .btn-control:hover {
            background: #4f46e5;
        }
        
        .stock-value {
            font-weight: 600;
            color: #212529;
            font-size: 1.125rem;
            min-width: 40px;
            text-align: center;
        }
        
        @media (max-width: 992px) {
            body {
                background: #ffffff;
            }
            
            .content-section {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .main-heading {
                font-size: 2.5rem;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Stock takes</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Stock takes</li>
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
        <div class="stocktakes-container">
        <div class="content-section">
            <div class="content-left">
                <div class="free-badge">Free to use</div>
                
                <h1 class="main-heading">Track and record your product stock</h1>
                
                <p class="main-description">
                    Manage and track your product inventory down to the item, view trends and insights with powerful reports.
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Use your barcode scanner to quickly count products</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Pause the stocktake anytime and resume it later</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Update your inventory immediately on completion</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Add important information with stocktake notes</span>
                    </li>
                </ul>

                <div class="cta-buttons">
                    <button class="btn btn-start">Start now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

           
        </div>
    </div>
    </div>
</div>

@endsection