@extends('store.layouts.app')

@section('title', 'Notifications')

@section('content')
   <style>
      
        
        .notifications-container {
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
        
        .link-text {
            color: #6366f1;
            text-decoration: none;
        }
        
        .link-text:hover {
            text-decoration: underline;
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
        
        .btn-setup {
            background: #212529;
            color: white;
            padding: 0.875rem 2.5rem;
            border-radius: 24px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .btn-setup:hover {
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
            max-width: 320px;
            margin: 0 auto;
            position: relative;
        }
        
        .phone-frame {
            background: #1e1b2e;
            border-radius: 40px;
            padding: 0.75rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .phone-screen {
            background: linear-gradient(135deg, #7c3aed 0%, #db2777 100%);
            border-radius: 32px;
            padding: 1.5rem 1rem;
            min-height: 600px;
            position: relative;
        }
        
        .status-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            font-size: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .time-large {
            text-align: center;
            color: white;
            margin-bottom: 2rem;
        }
        
        .day-text {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .time-text {
            font-size: 4rem;
            font-weight: 600;
            line-height: 1;
        }
        
        .notifications-stack {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .notification-card {
            background: white;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .notif-header {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 0.375rem;
        }
        
        .notif-icon {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            flex-shrink: 0;
        }
        
        .icon-purple {
            background: #e9d5ff;
            color: #9333ea;
        }
        
        .icon-green {
            background: #d1fae5;
            color: #059669;
        }
        
        .icon-yellow {
            background: #fef3c7;
            color: #d97706;
        }
        
        .notif-title {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            flex: 1;
        }
        
        .notif-time {
            color: #6b7280;
            font-size: 0.7rem;
        }
        
        .notif-message {
            color: #6b7280;
            font-size: 0.8rem;
            padding-left: 2rem;
        }
        
        .phone-bottom {
            position: absolute;
            bottom: 1rem;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 1.5rem;
            color: white;
        }
        
        .bottom-icon {
            font-size: 1.25rem;
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
            <h4 class="mb-sm-0">Notifications</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Notifications</li>
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
        <div class="notifications-container">
        <div class="content-section">
            <div class="content-left">
                <div class="free-badge">Free to use</div>
                
                <h1 class="main-heading">Engage with your clients and keep them up to date</h1>
                
                <p class="main-description">
                    Promote client loyalty and reduce no-shows with Fresha's <a href="#" class="link-text">automations</a>. Once sent, notifications will appear here on the messages history page.
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Keep your clients up to date with reminders and updates to avoid no-shows</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Encourage client loyalty and increase reviews with post appointment thank you messages</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Ensure your messages are received by sending them over text, WhatsApp, email and app notifications</span>
                    </li>
                </ul>

                <div class="cta-buttons">
                    <button class="btn btn-setup">Set up now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

            <div class="content-right">
                <div class="phone-mockup">
                    <div class="phone-frame">
                        <div class="phone-screen">
                            <div class="status-bar">
                                <span>? 5G</span>
                                <span>? 42%</span>
                            </div>
                            
                            <div class="time-large">
                                <div class="day-text">Monday, June 6</div>
                                <div class="time-text">9:41</div>
                            </div>

                            <div class="notifications-stack">
                                <div class="notification-card">
                                    <div class="notif-header">
                                        <div class="notif-icon icon-purple">
                                            <i class="bi bi-gift"></i>
                                        </div>
                                        <div class="notif-title">Happy birthday! ?</div>
                                        <div class="notif-time">now</div>
                                    </div>
                                    <div class="notif-message">Celebrate with 20% off</div>
                                </div>

                                <div class="notification-card">
                                    <div class="notif-header">
                                        <div class="notif-icon icon-green">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                        <div class="notif-title">Appointment confirmed</div>
                                        <div class="notif-time">2h</div>
                                    </div>
                                    <div class="notif-message">Thank you for booking</div>
                                </div>

                                <div class="notification-card">
                                    <div class="notif-header">
                                        <div class="notif-icon icon-yellow">
                                            <i class="bi bi-emoji-smile"></i>
                                        </div>
                                        <div class="notif-title">Thanks for visiting</div>
                                        <div class="notif-time">3d</div>
                                    </div>
                                    <div class="notif-message">See you in three Fridays</div>
                                </div>

                                <div class="notification-card">
                                    <div class="notif-header">
                                        <div class="notif-icon icon-green">
                                            <i class="bi bi-bell"></i>
                                        </div>
                                        <div class="notif-title">Appointment reminder</div>
                                        <div class="notif-time">4d</div>
                                    </div>
                                    <div class="notif-message">See you in 45m tomorrow</div>
                                </div>
                            </div>

                            <div class="phone-bottom">
                                <i class="bi bi-torch bottom-icon"></i>
                                <i class="bi bi-camera bottom-icon"></i>
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