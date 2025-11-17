@extends('store.layouts.app')

@section('title', 'Memberships')

@section('content')
<style>
        
        
        .membership-container {
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
        
        .membership-visual {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }
        
        .salon-image {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #fce7f3 0%, #e9d5ff 100%);
            border-radius: 12px;
            margin-bottom: 1rem;
            overflow: hidden;
            position: relative;
        }
        
        .salon-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .salon-info {
            margin-bottom: 1.5rem;
        }
        
        .salon-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.25rem;
        }
        
        .salon-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }
        
        .stars {
            color: #f59e0b;
            font-weight: 600;
        }
        
        .reviews {
            color: #6b7280;
        }
        
        .rating-label {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .services-section {
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-weight: 600;
            color: #212529;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }
        
        .service-item {
            padding: 0.875rem 0;
            border-bottom: 1px solid #f1f3f5;
        }
        
        .service-item:last-child {
            border-bottom: none;
        }
        
        .service-name {
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.25rem;
        }
        
        .service-duration {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .service-badge {
            display: inline-block;
            background: #f3f4f6;
            color: #6b7280;
            font-size: 0.75rem;
            padding: 0.25rem 0.625rem;
            border-radius: 4px;
            margin-top: 0.25rem;
        }
        
        .memberships-section {
            background: #f9fafb;
            border-radius: 12px;
            padding: 1rem;
        }
        
        .membership-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: white;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }
        
        .membership-item:last-child {
            margin-bottom: 0;
        }
        
        .membership-icon {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }
        
        .icon-green {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }
        
        .icon-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
        }
        
        .icon-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
        }
        
        .membership-info {
            flex: 1;
        }
        
        .membership-name {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }
        
        .membership-details {
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
            <h4 class="mb-sm-0">Memberships</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Memberships</li>
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
         <div class="membership-container">
        <div class="content-section">
            <div class="content-left">
                <div class="free-badge">Free to use</div>
                
                <h1 class="main-heading">Manage multi-session memberships</h1>
                
                <p class="main-description">
                    Boost your revenue by combining multiple treatments into a membership and turn your clients into regulars.
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Ensure a steady income with recurring memberships</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Encourage clients to buy an upfront course of treatments</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Clients can easily book and keep track of their remaining sessions</span>
                    </li>
                </ul>

                <div class="cta-buttons">
                    <button class="btn btn-start">Start now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

            <div class="content-right">
                <div class="membership-visual">
                    <div class="salon-image">
                        <svg width="100%" height="100%" viewBox="0 0 400 180" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="salonGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#fce7f3;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#e9d5ff;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <rect width="400" height="180" fill="url(#salonGradient)"/>
                            <rect x="50" y="30" width="80" height="100" rx="4" fill="#f3e8ff"/>
                            <rect x="160" y="30" width="80" height="100" rx="4" fill="#fce7f3"/>
                            <rect x="270" y="30" width="80" height="100" rx="4" fill="#f3e8ff"/>
                            <circle cx="90" cy="60" r="12" fill="#e9d5ff"/>
                            <circle cx="200" cy="60" r="12" fill="#fbbf24"/>
                            <circle cx="310" cy="60" r="12" fill="#e9d5ff"/>
                        </svg>
                    </div>
                    
                    <div class="salon-info">
                        <div class="salon-name">Trendy Studio</div>
                        <div class="salon-rating">
                            <span class="stars">5.0 ?</span>
                            <span class="reviews">120 reviews</span>
                        </div>
                        <div class="rating-label">Rating (all · 24h min.)</div>
                    </div>

                    <div class="services-section">
                        <div class="section-title">Short hair cut</div>
                        <div class="service-item">
                            <div class="service-name">Short hair cut</div>
                            <div class="service-duration">1 hour</div>
                            <span class="service-badge">Included in membership</span>
                        </div>
                        <div class="service-item">
                            <div class="service-name">Medium hair cut</div>
                            <div class="service-duration">1 hour</div>
                        </div>
                        <div class="service-item">
                            <div class="service-name">Long hair cut</div>
                            <div class="service-duration">1 hour</div>
                        </div>
                    </div>

                    <div class="memberships-section">
                        <div class="section-title">Memberships</div>
                        <div class="membership-item">
                            <div class="membership-icon icon-green">
                                <i class="bi bi-card-checklist"></i>
                            </div>
                            <div class="membership-info">
                                <div class="membership-name">Short hair services</div>
                                <div class="membership-details">Monthly plan</div>
                            </div>
                        </div>
                        <div class="membership-item">
                            <div class="membership-icon icon-blue">
                                <i class="bi bi-card-checklist"></i>
                            </div>
                            <div class="membership-info">
                                <div class="membership-name">Deluxe hair plan</div>
                                <div class="membership-details">6 sessions</div>
                            </div>
                        </div>
                        <div class="membership-item">
                            <div class="membership-icon icon-purple">
                                <i class="bi bi-card-checklist"></i>
                            </div>
                            <div class="membership-info">
                                <div class="membership-name">Premium</div>
                                <div class="membership-details">4 sessions</div>
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