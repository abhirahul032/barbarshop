@extends('store.layouts.app')

@section('title', 'Reviews')

@section('content')
<style>
      
        .reviews-container {
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
            font-size: 2.75rem;
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
        
        .btn-learn-more {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .btn-learn-more:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .reviews-card {
            background: white;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: 0 auto;
        }
        
        .top-rated-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            display: inline-block;
            margin-bottom: 0.75rem;
        }
        
        .business-image {
            width: 100%;
            height: 180px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
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
        
        .stars-rating {
            color: #f59e0b;
            font-weight: 600;
        }
        
        .reviews-count {
            color: #6b7280;
        }
        
        .reviews-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .review-item {
            background: #f9fafb;
            border-radius: 10px;
            padding: 0.875rem;
        }
        
        .review-header {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 0.5rem;
        }
        
        .review-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .review-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .review-info {
            flex: 1;
        }
        
        .review-author {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }
        
        .review-subtitle {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .review-meta {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.7rem;
        }
        
        .review-stars {
            color: #fbbf24;
        }
        
        .review-time {
            color: #9ca3af;
        }
        
        .review-text {
            color: #4b5563;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .btn-leave-review {
            background: #6366f1;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
        }
        
        .btn-leave-review:hover {
            background: #4f46e5;
            color: white;
        }
        
        .avatar-1 {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
        }
        
        .avatar-2 {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }
        
        .avatar-3 {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
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
                font-size: 2.25rem;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Reviews</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Reviews</li>
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
         <div class="reviews-container">
        <div class="content-section">
            <div class="content-left">
                <div class="free-badge">Free to use</div>
                
                <h1 class="main-heading">Boost your reputation and attract new clients with trusted reviews</h1>
                
                <p class="main-description">
                    Collecting authentic reviews is a proven way to gain new clients. Reply to reviews to grow relationships, showing clients you care about their feedback.
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Check out <a href="#" class="link-text">appointments</a> to automatically prompt clients to leave reviews</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Keep your automated <a href="#" class="link-text">Thank you messages</a> enabled to boost your reviews and star ratings after your clients visit</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Attract new clients with authentic reviews coming from your satisfied customers</span>
                    </li>
                </ul>

                <button class="btn btn-learn-more">Learn more</button>
            </div>

            <div class="content-right">
                <div class="reviews-card">
                    <div class="top-rated-badge">Top-rated</div>
                    
                    <div class="business-image">
                        <svg width="100%" height="100%" viewBox="0 0 400 180" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="salonGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#fbbf24;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#f59e0b;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <rect width="400" height="180" fill="url(#salonGradient)"/>
                            <circle cx="120" cy="90" r="35" fill="#fde68a" opacity="0.4"/>
                            <circle cx="280" cy="90" r="35" fill="#fde68a" opacity="0.4"/>
                        </svg>
                    </div>

                    <div class="business-info">
                        <div class="business-name">Trendy Studio</div>
                        <div class="business-rating">
                            <span class="stars-rating">5.0 ?????</span>
                            <span class="reviews-count">750 reviews</span>
                        </div>
                    </div>

                    <div class="reviews-list">
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-avatar avatar-1">
                                    <svg width="100%" height="100%" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="18" cy="18" r="18" fill="url(#grad1)"/>
                                        <defs>
                                            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" style="stop-color:#fb923c"/>
                                                <stop offset="100%" style="stop-color:#f97316"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="review-info">
                                    <div class="review-author">Amazing service</div>
                                    <div class="review-meta">
                                        <span class="review-stars">?????</span>
                                        <span class="review-time">Today</span>
                                    </div>
                                </div>
                            </div>
                            <div class="review-text">How was your experience with Trendy Studio?</div>
                        </div>

                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-avatar avatar-2">
                                    <svg width="100%" height="100%" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="18" cy="18" r="18" fill="url(#grad2)"/>
                                        <defs>
                                            <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" style="stop-color:#34d399"/>
                                                <stop offset="100%" style="stop-color:#10b981"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="review-info">
                                    <div class="review-author">I love it!</div>
                                    <div class="review-subtitle">The best salon</div>
                                </div>
                            </div>
                            <div class="review-meta" style="margin-top: 0.5rem;">
                                <span class="review-stars">?????</span>
                            </div>
                        </div>

                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-avatar avatar-3">
                                    <svg width="100%" height="100%" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="18" cy="18" r="18" fill="url(#grad3)"/>
                                        <defs>
                                            <linearGradient id="grad3" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" style="stop-color:#fbbf24"/>
                                                <stop offset="100%" style="stop-color:#f59e0b"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="review-info">
                                    <div class="review-author">Can't wait to...</div>
                                    <div class="review-meta">
                                        <span class="review-stars">?????</span>
                                        <span class="review-time">9h ago</span>
                                    </div>
                                </div>
                            </div>
                            <div class="review-text">It was extraordinary, as always</div>
                        </div>
                    </div>

                    <button class="btn btn-leave-review">Leave review</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection