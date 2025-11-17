@extends('store.layouts.app')

@section('title', 'Settings')

@section('content')
 <style>
       
        
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
        }
        
        .btn-continue-setup {
            background: #8b5cf6;
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-continue-setup:hover {
            background: #7c3aed;
            color: white;
        }
        
        .nav-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #374151;
            font-size: 1.25rem;
        }
        
        .nav-icon:hover {
            background: #f3f4f6;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        
        .tabs-navigation {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }
        
        .tab-btn {
            padding: 0.625rem 1.25rem;
            border-radius: 20px;
            border: none;
            background: white;
            color: #374151;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
        }
        
        .tab-btn:hover {
            background: #f9fafb;
        }
        
        .tab-btn.active {
            background: #212529;
            color: white;
        }
        
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        
        .setting-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .setting-card:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }
        
        .setting-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }
        
        .setting-icon i {
            font-size: 1.5rem;
            color: #8b5cf6;
        }
        
        .setting-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        
        .setting-description {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        
        @media (max-width: 992px) {
            .settings-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
            
            .top-navbar {
                padding: 0.75rem 1rem;
            }
            
            .main-content {
                padding: 2rem 1rem;
            }
            
            .page-title {
                font-size: 1.75rem;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Settings</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Settings</li>
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
        <div class="main-contentsss">
        <div class="page-header">
            <h1 class="page-title">Workspace settings</h1>
            <p class="page-subtitle">Manage settings for test.</p>
        </div>

        <div class="tabs-navigation">
            <button class="tab-btn active">Settings</button>
            <button class="tab-btn">Online presence</button>
            <button class="tab-btn">Marketing</button>
            <button class="tab-btn">Other</button>
        </div>

        <div class="settings-grid">
            <div class="setting-card">
                <div class="setting-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <h3 class="setting-title">Business setup</h3>
                <p class="setting-description">
                    Customize business details, manage locations, and client referral sources.
                </p>
            </div>

            <div class="setting-card">
                <div class="setting-icon">
                    <i class="bi bi-calendar3"></i>
                </div>
                <h3 class="setting-title">Scheduling</h3>
                <p class="setting-description">
                    Set your availability, manage bookable resources and online booking preferences.
                </p>
            </div>

            <div class="setting-card">
                <div class="setting-icon">
                    <i class="bi bi-tag"></i>
                </div>
                <h3 class="setting-title">Sales</h3>
                <p class="setting-description">
                    Configure payment methods, taxes, receipts, service charges and gift cards.
                </p>
            </div>

            <div class="setting-card">
                <div class="setting-icon">
                    <i class="bi bi-building"></i>
                </div>
                <h3 class="setting-title">Billing</h3>
                <p class="setting-description">
                    Manage Fresha invoices, messaging balance, add-ons and billing.
                </p>
            </div>

            <div class="setting-card">
                <div class="setting-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3 class="setting-title">Team</h3>
                <p class="setting-description">
                    Manage permissions, compensation and time-off.
                </p>
            </div>

            <div class="setting-card">
                <div class="setting-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3 class="setting-title">Forms</h3>
                <p class="setting-description">
                    Configure templates for client forms.
                </p>
            </div>

            <div class="setting-card">
                <div class="setting-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <h3 class="setting-title">Payments</h3>
                <p class="setting-description">
                    Configure payment methods, terminals
                </p>
            </div>
        </div>
    </div>
    </div>
</div>
 <script>
        // Tab navigation
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Setting cards click
        document.querySelectorAll('.setting-card').forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('.setting-title').textContent;
                console.log('Navigate to:', title);
                // You can add navigation logic here
            });
        });
    </script>
@endsection