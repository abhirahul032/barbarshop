@extends('store.layouts.app')

@section('title', 'Add ons')

@section('content')
 <style>
        
        
        .page-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .page-header {
            margin-bottom: 3rem;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.75rem;
        }
        
        .page-subtitle {
            font-size: 1.125rem;
            color: #6b7280;
            margin-bottom: 3rem;
        }
        
        .section-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 2rem;
        }
        
        .addons-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        
        .addon-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .addon-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .trial-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: #dbeafe;
            color: #2563eb;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .addon-icon {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            flex-shrink: 0;
        }
        
        .addon-icon i {
            font-size: 2rem;
            color: white;
        }
        
        .icon-blue {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        
        .icon-purple {
            background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
        }
        
        .icon-purple-alt {
            background: linear-gradient(135deg, #c084fc 0%, #a855f7 100%);
        }
        
        .icon-yellow {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }
        
        .icon-pink {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        }
        
        .icon-green {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }
        
        .addon-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.75rem;
        }
        
        .addon-description {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex: 1;
        }
        
        .btn-view {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            align-self: flex-start;
        }
        
        .btn-view:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        @media (max-width: 992px) {
            .addons-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .addons-grid {
                grid-template-columns: 1fr;
            }
            
            .page-title {
                font-size: 2rem;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Add ons</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Add ons</li>
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
        <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Fresha add-ons</h1>
            <p class="page-subtitle">Take your business to the next level with Fresha add-ons.</p>
        </div>

        <div class="addons-section">
            <h2 class="section-title">Add-ons</h2>
            
            <div class="addons-grid">
                <!-- Payments -->
                <div class="addon-card">
                    <div class="addon-icon icon-blue">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h3 class="addon-title">Payments</h3>
                    <p class="addon-description">
                        Get paid by clients online and in-store with low cost, safe and simple payments integrated directly to your workspace.
                    </p>
                    <button class="btn btn-view">View</button>
                </div>

                <!-- Premium Support -->
                <div class="addon-card">
                    <span class="trial-badge">On free trial</span>
                    <div class="addon-icon icon-purple">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h3 class="addon-title">Premium Support</h3>
                    <p class="addon-description">
                        Get the most out of the Fresha platform and it's features with help from our experienced business support specialists.
                    </p>
                    <button class="btn btn-view">View</button>
                </div>

                <!-- Insights -->
                <div class="addon-card">
                    <div class="addon-icon icon-purple-alt">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>
                    <h3 class="addon-title">Insights</h3>
                    <p class="addon-description">
                        Unlock additional reports and create your own unique reports which you can share with your team
                    </p>
                    <button class="btn btn-view">View</button>
                </div>

                <!-- Google Rating Boost -->
                <div class="addon-card">
                    <div class="addon-icon icon-yellow">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h3 class="addon-title">Google Rating Boost</h3>
                    <p class="addon-description">
                        Prompt your clients to leave a Google review after they've had a positive experience and increase your footfall.
                    </p>
                    <button class="btn btn-view">View</button>
                </div>

                <!-- Client Loyalty -->
                <div class="addon-card">
                    <div class="addon-icon icon-pink">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h3 class="addon-title">Client Loyalty</h3>
                    <p class="addon-description">
                        Encourage repeat visits and larger purchases by rewarding clients with exclusive offers that celebrate their loyalty
                    </p>
                    <button class="btn btn-view">View</button>
                </div>

                <!-- Data Connector -->
                <div class="addon-card">
                    <div class="addon-icon icon-green">
                        <i class="bi bi-link-45deg"></i>
                    </div>
                    <h3 class="addon-title">Data Connector</h3>
                    <p class="addon-description">
                        Connect the power of Fresha data to your external spreadsheets, systems and other software
                    </p>
                    <button class="btn btn-view">View</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection