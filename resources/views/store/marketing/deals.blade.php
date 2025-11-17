@extends('store.layouts.app')

@section('title', 'Deals')

@section('content')
 <style>
      
        
        .deals-container {
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
        
        .deal-card {
            background: white;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
            max-width: 380px;
            margin: 0 auto;
        }
        
        .deal-badge {
            background: linear-gradient(135deg, #a78bfa 0%, #34d399 100%);
            color: white;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            display: inline-block;
            margin-bottom: 0.75rem;
        }
        
        .deal-image {
            width: 100%;
            height: 180px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
            position: relative;
            background: linear-gradient(135deg, #fde68a 0%, #f59e0b 100%);
        }
        
        .promo-overlay {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            background: white;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .promo-label {
            color: #6b7280;
            font-size: 0.7rem;
            margin-bottom: 0.125rem;
        }
        
        .promo-code {
            color: #212529;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .business-info {
            margin-bottom: 1rem;
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
        
        .flash-sale {
            background: #fef3c7;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .flash-icon {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #f59e0b;
        }
        
        .flash-text {
            flex: 1;
        }
        
        .flash-title {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }
        
        .flash-description {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        
        .price-old {
            text-decoration: line-through;
            color: #9ca3af;
            font-size: 0.875rem;
        }
        
        .price-new {
            font-weight: 600;
            color: #212529;
            font-size: 1rem;
        }
        
        .time-slots {
            border-top: 1px solid #f1f3f5;
            padding-top: 1rem;
            margin-bottom: 1rem;
        }
        
        .time-slot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.625rem 0;
        }
        
        .time-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .time-value {
            font-weight: 500;
            color: #212529;
            font-size: 0.875rem;
        }
        
        .discount-badge {
            background: #dcfce7;
            color: #16a34a;
            font-weight: 600;
            padding: 0.125rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
        }
        
        .price-strike {
            text-decoration: line-through;
            color: #9ca3af;
            font-size: 0.75rem;
        }
        
        .price-final {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
        }
        
        .last-minute {
            background: #f9fafb;
            border-radius: 8px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .last-minute-icon {
            width: 36px;
            height: 36px;
            background: #ede9fe;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            color: #8b5cf6;
        }
        
        .last-minute-text {
            flex: 1;
        }
        
        .last-minute-title {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }
        
        .last-minute-description {
            color: #6b7280;
            font-size: 0.75rem;
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
            <h4 class="mb-sm-0">Deals</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Deals</li>
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
        <div class="deals-container">
        <div class="content-section">
            <div class="content-left">
                <div class="free-badge">Free to use</div>
                
                <h1 class="main-heading">Reward and retain clients with deals</h1>
                
                <p class="main-description">
                    Whether you create discount codes for holidays, off-peak prices or offers to attract new clients, deals are a great way to increase sales.
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Create and share a promotion with a discount code</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Introduce a flash sale to get more bookings</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Quickly fill your calendar with last-minute offers</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Control and track the performance of all deals from one place</span>
                    </li>
                </ul>

                <div class="cta-buttons">
                    <button class="btn btn-start">Start now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

            <div class="content-right">
                <div class="deal-card">
                    <div class="deal-badge">Great deal</div>
                    
                    <div class="deal-image">
                        <svg width="100%" height="100%" viewBox="0 0 400 180" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="spaGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#fde68a;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#f59e0b;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <rect width="400" height="180" fill="url(#spaGradient)"/>
                            <circle cx="120" cy="90" r="40" fill="#fbbf24" opacity="0.3"/>
                            <circle cx="280" cy="90" r="40" fill="#fbbf24" opacity="0.3"/>
                        </svg>
                        
                        <div class="promo-overlay">
                            <div class="promo-label">Promotion</div>
                            <div class="promo-code">Save 20% with SAVE20</div>
                        </div>
                    </div>

                    <div class="business-info">
                        <div class="business-name">Trendy Studio</div>
                        <div class="business-rating">
                            <span class="stars">5.0 ?????</span>
                            <span class="reviews">100 reviews</span>
                        </div>
                    </div>

                    <div class="flash-sale">
                        <div class="flash-icon">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <div class="flash-text">
                            <div class="flash-title">Flash Sale</div>
                            <div class="flash-description">Get their perfect hair for free</div>
                        </div>
                    </div>

                    <div class="price-row">
                        <span class="price-old">$80</span>
                        <span class="price-new">$100</span>
                    </div>

                    <div class="time-slots">
                        <div class="time-slot">
                            <div class="time-left">
                                <span class="time-value">10:30am</span>
                                <span class="discount-badge">-20% off</span>
                                <span class="price-strike">$100</span>
                            </div>
                            <span class="price-final">$95</span>
                        </div>
                        <div class="time-slot">
                            <span class="time-value">11:00am</span>
                            <span class="price-final">$100</span>
                        </div>
                    </div>

                    <div class="last-minute">
                        <div class="last-minute-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="last-minute-text">
                            <div class="last-minute-title">Last-minute deals</div>
                            <div class="last-minute-description">Limited spots available!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection