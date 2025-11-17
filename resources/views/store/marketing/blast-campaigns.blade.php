@extends('store.layouts.app')

@section('title', 'Blast Campaigns')

@section('content')
<style>
       
        
        .campaigns-container {
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
        
        .phone-mockup {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            max-width: 320px;
            margin: 0 auto;
        }
        
        .promo-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .promo-illustration {
            width: 100%;
            height: 150px;
            margin-bottom: 1rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .product-items {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            max-width: 200px;
            margin: 0 auto 1rem;
        }
        
        .product-item {
            width: 50px;
            height: 60px;
            border-radius: 8px;
        }
        
        .item-lipstick {
            background: linear-gradient(135deg, #fb7185 0%, #f43f5e 100%);
        }
        
        .item-bottle {
            background: linear-gradient(135deg, #5eead4 0%, #2dd4bf 100%);
        }
        
        .item-compact {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }
        
        .item-tube {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
        }
        
        .item-jar {
            background: linear-gradient(135deg, #c084fc 0%, #a855f7 100%);
        }
        
        .item-serum {
            background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
        }
        
        .promo-heading {
            font-size: 1.25rem;
            font-weight: 700;
            color: #dc2626;
            margin-bottom: 0.5rem;
        }
        
        .promo-subtext {
            color: #f87171;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .btn-book {
            background: #fb7185;
            color: white;
            border: none;
            padding: 0.625rem 2rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .btn-book:hover {
            background: #f43f5e;
            color: white;
        }
        
        .message-sender {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 12px;
        }
        
        .sender-avatar {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .sender-info {
            flex: 1;
        }
        
        .sender-name {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }
        
        .sender-message {
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
            <h4 class="mb-sm-0">Blast Campaigns</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Blast Campaigns</li>
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
        <div class="campaigns-container">
        <div class="content-section">
            <div class="content-left">
                <h1 class="main-heading">Promote your business with blast campaigns</h1>
                
                <p class="main-description">
                    Increase bookings and engage with your clients by sharing special offers and important updates over email and text message.
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Customize the message content to suit your style</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Target all clients, specific client groups or individuals</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Access powerful real-time campaign reporting</span>
                    </li>
                </ul>

                <div class="cta-buttons">
                    <button class="btn btn-start">Start now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

            <div class="content-right">
                <div class="phone-mockup">
                    <div class="promo-card">
                        <div class="promo-illustration">
                            <div class="product-items">
                                <div class="product-item item-lipstick"></div>
                                <div class="product-item item-bottle"></div>
                                <div class="product-item item-compact"></div>
                                <div class="product-item item-tube"></div>
                                <div class="product-item item-jar"></div>
                                <div class="product-item item-serum"></div>
                            </div>
                        </div>
                        <h2 class="promo-heading">All services and products 20% off!</h2>
                        <p class="promo-subtext">Book your appointment with us at a discount</p>
                        <button class="btn btn-book">Book now</button>
                    </div>

                    <div class="message-sender">
                        <div class="sender-avatar">L</div>
                        <div class="sender-info">
                            <div class="sender-name">London Salon Team</div>
                            <div class="sender-message">SALE! All services and products 20% off!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection