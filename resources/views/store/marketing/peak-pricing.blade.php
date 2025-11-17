@extends('store.layouts.app')

@section('title', 'Peak Pricing')

@section('content')
 <style>
        
        
        .pricing-container {
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
        
        .business-card {
            background: white;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
            max-width: 380px;
            margin: 0 auto;
        }
        
        .business-image {
            width: 100%;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #f9a8d4 0%, #ec4899 100%);
        }
        
        .business-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .business-info {
            margin-bottom: 1.5rem;
        }
        
        .business-name {
            font-weight: 600;
            color: #212529;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        
        .business-rating {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.75rem;
        }
        
        .stars {
            color: #f59e0b;
            font-weight: 600;
        }
        
        .reviews {
            color: #6b7280;
        }
        
        .pricing-options {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .pricing-option {
            background: #f9fafb;
            border-radius: 10px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }
        
        .option-icon {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            flex-shrink: 0;
        }
        
        .icon-green {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }
        
        .icon-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
        }
        
        .option-label {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
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
            <h4 class="mb-sm-0">Peak Pricing</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Peak Pricing</li>
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
        <div class="pricing-container">
        <div class="content-section">
            <div class="content-left">
                <div class="free-badge">Free to use</div>
                
                <h1 class="main-heading">Get more sales with surge and off-peak pricing</h1>
                
                <p class="main-description">
                    Automatically adjust your service prices, charging different amount during more or less busy hours.
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Introduce off-peak intervals to offer a discount and get more bookings</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Increase prices on busy hours to maximise sales value</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Track performance to get insights and make informed pricing decisions</span>
                    </li>
                </ul>

                <div class="cta-buttons">
                    <button class="btn btn-start">Start now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

            <div class="content-right">
                <div class="business-card">
                    <div class="business-image">
                        <svg width="100%" height="100%" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="pinkGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#f9a8d4;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#ec4899;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <rect width="400" height="200" fill="url(#pinkGradient)"/>
                            <circle cx="200" cy="80" r="50" fill="#fbbf24" opacity="0.2"/>
                            <path d="M 150 120 Q 200 140 250 120" stroke="#fbbf24" stroke-width="4" fill="none" opacity="0.3"/>
                        </svg>
                    </div>

                    <div class="business-info">
                        <div class="business-name">Trendy Studio</div>
                        <div class="business-rating">
                            <span class="stars">5.0 ?????</span>
                            <span class="reviews">100 reviews</span>
                        </div>
                    </div>

                    <div class="pricing-options">
                        <div class="pricing-option">
                            <div class="option-icon icon-green">
                                <i class="bi bi-percent"></i>
                            </div>
                            <div class="option-label">Off-peak pricing</div>
                        </div>

                        <div class="pricing-option">
                            <div class="option-icon icon-purple">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="option-label">Surge price</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection