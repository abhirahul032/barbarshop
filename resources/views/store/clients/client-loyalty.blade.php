@extends('store.layouts.app')

@section('title', 'Client Loyalty')

@section('content')
 <style>
        body {
            background: linear-gradient(135deg, #f5f3ff 0%, #fae8ff 50%, #fbcfe8 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
            padding: 3rem 0;
        }
        
        .loyalty-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .addon-badge {
            display: inline-flex;
            align-items: center;
            background: white;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .addon-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
            margin-right: 0.75rem;
        }
        
        .addon-text {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
        }
        
        .content-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .main-heading {
            font-size: 3.5rem;
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
        
        .pricing-section {
            margin-bottom: 2rem;
        }
        
        .save-badge {
            display: inline-block;
            background: #dcfce7;
            color: #16a34a;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }
        
        .pricing {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .old-price {
            font-size: 1.5rem;
            color: #9ca3af;
            text-decoration: line-through;
            font-weight: 400;
        }
        
        .new-price {
            font-size: 2rem;
            color: #212529;
            font-weight: 700;
        }
        
        .price-details {
            color: #6b7280;
            font-size: 1rem;
        }
        
        .trial-text {
            color: #374151;
            font-weight: 500;
            margin-bottom: 2rem;
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
        
        .loyalty-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        .hexagon-badge {
            width: 400px;
            height: 400px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hex-layer {
            position: absolute;
            width: 100%;
            height: 100%;
            clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);
        }
        
        .hex-outer {
            background: linear-gradient(135deg, #ec4899 0%, #f9a8d4 100%);
            transform: scale(1);
            opacity: 0.9;
        }
        
        .hex-middle {
            background: linear-gradient(135deg, #f472b6 0%, #fbcfe8 100%);
            transform: scale(0.85);
        }
        
        .hex-inner {
            background: linear-gradient(135deg, #fda4af 0%, #fce7f3 100%);
            transform: scale(0.7);
        }
        
        .hex-core {
            background: white;
            transform: scale(0.55);
        }
        
        .checkmark {
            position: absolute;
            font-size: 120px;
            color: #ec4899;
            z-index: 10;
            font-weight: 300;
        }
        
        @media (max-width: 992px) {
            .content-section {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .main-heading {
                font-size: 2.5rem;
            }
            
            .hexagon-badge {
                width: 300px;
                height: 300px;
            }
            
            .checkmark {
                font-size: 80px;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Client Loyalty</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Client Loyalty</li>
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
         <div class="loyalty-container">
        <div class="addon-badge">
            <div class="addon-icon">
                <i class="bi bi-gem"></i>
            </div>
            <div class="addon-text">Client Loyalty add-on</div>
        </div>

        <div class="content-section">
            <div class="content-left">
                <h1 class="main-heading">Turn all clients into regulars</h1>
                
                <p class="main-description">
                    Watch your sales skyrocket with a custom loyalty program - encouraging repeat visits and larger purchases.
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Offer the ultimate loyalty experience with points, tiers and referrals</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Reward your clients with exclusive offers, discounts and incentives to celebrate their loyalty</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Allow clients to easily track their progress and redeem rewards online</span>
                    </li>
                </ul>

                <div class="pricing-section">
                    <div class="save-badge">Save 20%</div>
                    <div class="pricing">
                        <span class="old-price">?5,000.00</span>
                        <span class="new-price">?4,000.00</span>
                        <span class="price-details">per location, per month</span>
                    </div>
                    <div class="trial-text">Try it FREE for 7 days!</div>
                </div>

                <div class="cta-buttons">
                    <button class="btn btn-start">Start now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

            <div class="content-right">
                <div class="loyalty-visual">
                    <div class="hexagon-badge">
                        <div class="hex-layer hex-outer"></div>
                        <div class="hex-layer hex-middle"></div>
                        <div class="hex-layer hex-inner"></div>
                        <div class="hex-layer hex-core"></div>
                        <div class="checkmark">?</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection