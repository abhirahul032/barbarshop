@extends('store.layouts.app')

@section('title', 'Products')

@section('content')
 <style>
      
        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
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
        
        .link-text {
            color: #6366f1;
            text-decoration: none;
        }
        
        .link-text:hover {
            text-decoration: underline;
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
        
        .products-visual {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }
        
        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .products-title {
            font-weight: 600;
            color: #212529;
            font-size: 1.125rem;
        }
        
        .search-icon {
            color: #6b7280;
            font-size: 1.25rem;
            cursor: pointer;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .product-card {
            background: #f9fafb;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            position: relative;
        }
        
        .product-image {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            position: relative;
        }
        
        .product-image img {
            max-width: 80%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .product-price {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }
        
        .product-name {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .stock-badge {
            position: absolute;
            bottom: 0.75rem;
            right: 0.75rem;
            background: #dbeafe;
            color: #3b82f6;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }
        
        .bottle-mint {
            background: linear-gradient(135deg, #6ee7b7 0%, #34d399 100%);
            border-radius: 8px;
            width: 60px;
            height: 100px;
            margin: 0 auto;
        }
        
        .bottle-yellow {
            background: linear-gradient(135deg, #fde047 0%, #facc15 100%);
            border-radius: 8px;
            width: 60px;
            height: 100px;
            margin: 0 auto;
        }
        
        .tube-brown {
            background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
            border-radius: 4px;
            width: 50px;
            height: 90px;
            margin: 0 auto;
        }
        
        .tube-beige {
            background: linear-gradient(135deg, #fde68a 0%, #fcd34d 100%);
            border-radius: 4px;
            width: 50px;
            height: 90px;
            margin: 0 auto;
        }
        
        .bottle-red {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-radius: 8px;
            width: 55px;
            height: 95px;
            margin: 0 auto;
        }
        
        .bottle-blue {
            background: linear-gradient(135deg, #93c5fd 0%, #60a5fa 100%);
            border-radius: 8px;
            width: 65px;
            height: 105px;
            margin: 0 auto;
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
            <h4 class="mb-sm-0">Products</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Products</li>
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
        <div class="products-container">
        <div class="content-section">
            <div class="content-left">
                <div class="free-badge">Free to use</div>
                
                <h1 class="main-heading">Manage your inventory with Fresha product list</h1>
                
                <p class="main-description">
                    Manage your inventory and stock levels for easy ordering, tracking and selling:
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Start with a single product or <a href="#" class="link-text">import many at once</a></span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Organize your list by adding brands and categories</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Keep quantity at the right level with low stock reminders</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Sell products online and during checkout at Point of Sale</span>
                    </li>
                </ul>

                <div class="cta-buttons">
                    <button class="btn btn-start">Start now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

            <div class="content-right">
                
            </div>
        </div>
    </div>
    </div>
</div>

@endsection