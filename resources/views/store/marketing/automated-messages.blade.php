@extends('store.layouts.app')

@section('title', 'Automacted Messages')

@section('content')
 <style>
       
        .page-header {
            background: white;
            padding: 2rem 0 1.5rem;
            margin-bottom: 0;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #212529;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        .page-subtitle a {
            color: #6366f1;
            text-decoration: none;
        }
        
        .page-subtitle a:hover {
            text-decoration: underline;
        }
        
        .balance-widget {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.75rem 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .balance-label {
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .balance-value {
            font-weight: 600;
            color: #212529;
            font-size: 1.125rem;
        }
        
        .info-banner {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            color: white;
            margin: 1.5rem 0;
        }
        
        .banner-title {
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }
        
        .banner-description {
            font-size: 0.95rem;
            margin-bottom: 1rem;
            opacity: 0.95;
        }
        
        .btn-setup {
            background: white;
            color: #6366f1;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-setup:hover {
            background: #f8f9fa;
            color: #6366f1;
        }
        
        .tabs-nav {
            background: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e9ecef;
            overflow-x: auto;
            white-space: nowrap;
        }
        
        .tab-btn {
            background: transparent;
            border: none;
            padding: 0.5rem 1.25rem;
            margin-right: 0.5rem;
            border-radius: 20px;
            font-weight: 500;
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .tab-btn.active {
            background: #212529;
            color: white;
        }
        
        .tab-btn:hover:not(.active) {
            background: #f1f3f5;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 1.5rem;
        }
        
        .automation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .automation-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            transition: box-shadow 0.2s;
        }
        
        .automation-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .icon-orange {
            background: #fff7ed;
            color: #f97316;
        }
        
        .icon-purple {
            background: #f3e8ff;
            color: #a855f7;
        }
        
        .icon-indigo {
            background: #eef2ff;
            color: #6366f1;
        }
        
        .card-title {
            font-weight: 600;
            color: #212529;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .card-description {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .status-badge {
            background: #dcfce7;
            color: #16a34a;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
        }
        
        .channel-icons {
            display: flex;
            gap: 0.5rem;
        }
        
        .channel-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            border: 1px solid #e9ecef;
            color: #6c757d;
        }
        
        .create-card {
            border: 2px dashed #dee2e6;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .create-card:hover {
            border-color: #6366f1;
            background: #f8f9fa;
        }
        
        .create-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #6366f1;
            margin-bottom: 0.75rem;
        }
        
        .create-text {
            color: #6366f1;
            font-weight: 600;
            font-size: 0.95rem;
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Automacted Messages</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Automacted Messages</li>
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
        <div class="page-header">
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <h1 class="page-title">Automations</h1>
                    <p class="page-subtitle">View and manage all automated messages sent to your clients. <a href="#">Learn more</a></p>
                </div>
                <div class="col-md-3 text-end">
                    <div class="balance-widget">
                        <div>
                            <div class="balance-label">Messaging balance</div>
                            <div class="balance-value">?0</div>
                        </div>
                        <i class="bi bi-three-dots-vertical" style="color: #6c757d; cursor: pointer;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <!-- Info Banner -->
        <div class="info-banner">
            <div class="banner-title">Make sure your messages always send with automatic top-ups</div>
            <div class="banner-description">Prevent your balance from reaching zero, and your messages will always reach your clients.</div>
            <button class="btn btn-setup">
                Set up
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs-nav">
            <button class="tab-btn active">Reminders</button>
            <button class="tab-btn">Appointment updates</button>
            <button class="tab-btn">Waitlist updates</button>
            <button class="tab-btn">Increase bookings</button>
            <button class="tab-btn">Celebrate milestones</button>
            <button class="tab-btn">Client loyalty</button>
        </div>

        <!-- Reminders Section -->
        <div class="section-title">Reminders</div>
        <div class="automation-grid">
            <div class="automation-card">
                <div class="card-icon icon-orange">
                    <i class="bi bi-bell"></i>
                </div>
                <div class="card-title">24 hours upcoming appointment reminder</div>
                <div class="card-description">Notifies clients reminding them of their upcoming appointment.</div>
                <div class="card-footer">
                    <span class="status-badge">Enabled</span>
                    <div class="channel-icons">
                        <div class="channel-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="automation-card">
                <div class="card-icon icon-orange">
                    <i class="bi bi-bell"></i>
                </div>
                <div class="card-title">1 hour upcoming appointment reminder</div>
                <div class="card-description">Notifies clients reminding them of their upcoming appointment.</div>
                <div class="card-footer">
                    <span class="status-badge">Enabled</span>
                    <div class="channel-icons">
                        <div class="channel-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="automation-card create-card">
                <div class="create-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div class="create-text">Create new</div>
            </div>
        </div>

        <!-- Appointment Updates Section -->
        <div class="section-title">Appointment updates</div>
        <div class="automation-grid">
            <div class="automation-card">
                <div class="card-icon icon-indigo">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="card-title">New appointment</div>
                <div class="card-description">Reach out to clients when their appointment is booked for them.</div>
                <div class="card-footer">
                    <span class="status-badge">Enabled</span>
                    <div class="channel-icons">
                        <div class="channel-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="automation-card">
                <div class="card-icon icon-purple">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="card-title">Rescheduled appointment</div>
                <div class="card-description">Automatically sends to clients when their appointment start time is changed.</div>
                <div class="card-footer">
                    <span class="status-badge">Enabled</span>
                    <div class="channel-icons">
                        <div class="channel-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="automation-card">
                <div class="card-icon icon-indigo">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <div class="card-title">Canceled appointment</div>
                <div class="card-description">Automatically sends to clients when their appointment is canceled.</div>
                <div class="card-footer">
                    <span class="status-badge">Enabled</span>
                    <div class="channel-icons">
                        <div class="channel-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="automation-card">
                <div class="card-icon icon-purple">
                    <i class="bi bi-telephone-x"></i>
                </div>
                <div class="card-title">Did not show up</div>
                <div class="card-description">Automatically sends to clients when their appointment is marked as a no-show.</div>
                <div class="card-footer">
                    <span class="status-badge">Enabled</span>
                    <div class="channel-icons">
                        <div class="channel-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <div class="channel-icon">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection