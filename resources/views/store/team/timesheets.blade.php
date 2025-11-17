@extends('store.layouts.app')

@section('title', 'Timesheets')

@section('content')
 <style>
       
        
        .timesheet-container {
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
        
        .timesheet-cards {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 420px;
            margin: 0 auto;
        }
        
        .timesheet-card {
            background: white;
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        
        .clocked-out-badge {
            background: #a78bfa;
            color: white;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            margin-bottom: 1rem;
        }
        
        .card-header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
        }
        
        .timesheet-title {
            font-weight: 600;
            color: #212529;
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
        }
        
        .timesheet-date {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-name {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
        }
        
        .timeline {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        
        .timeline-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }
        
        .timeline-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        
        .icon-clock-in {
            background: #dbeafe;
            color: #3b82f6;
        }
        
        .icon-coffee {
            background: #fef3c7;
            color: #f59e0b;
        }
        
        .icon-lunch {
            background: #fde68a;
            color: #f59e0b;
        }
        
        .icon-clock-out {
            background: #f3f4f6;
            color: #6b7280;
        }
        
        .timeline-content {
            flex: 1;
        }
        
        .timeline-title {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }
        
        .timeline-subtitle {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .employee-card {
            background: white;
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        
        .employee-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .employee-name {
            font-weight: 600;
            color: #212529;
            font-size: 1.125rem;
        }
        
        .employee-rating {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
        
        .rating-value {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
        }
        
        .rating-stars {
            color: #fbbf24;
            font-size: 0.875rem;
        }
        
        .employee-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }
        
        .timesheet-entries {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .timesheet-entry {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }
        
        .entry-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        
        .icon-pending {
            background: #fef3c7;
            color: #f59e0b;
        }
        
        .icon-approved {
            background: #dcfce7;
            color: #16a34a;
        }
        
        .entry-content {
            flex: 1;
        }
        
        .entry-title {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }
        
        .entry-status {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .entry-hours {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
        }
        
        .clock-in-banner {
            background: #ddd6fe;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }
        
        .banner-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b5cf6;
            font-size: 1.125rem;
            flex-shrink: 0;
        }
        
        .banner-content {
            flex: 1;
        }
        
        .banner-title {
            font-weight: 600;
            color: #5b21b6;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }
        
        .banner-subtitle {
            color: #6b21a8;
            font-size: 0.8rem;
        }
        
        .avatar-sarah {
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .avatar-tony {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
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
            <h4 class="mb-sm-0">Timesheets</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Timesheets</li>
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
         <div class="timesheet-container">
        <div class="content-section">
            <div class="content-left">
                <div class="free-badge">Free to use</div>
                
                <h1 class="main-heading">Simplify time tracking and attendance</h1>
                
                <p class="main-description">
                    Track your team's working hours and make pay calculations straightforward with Fresha timesheets
                </p>

                <ul class="features-list">
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Track worked hours and breaks in real time</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Fully integrated with Fresha Pay Runs</span>
                    </li>
                    <li>
                        <i class="bi bi-check-lg check-icon"></i>
                        <span>Detailed reporting to monitor attendance and punctuality</span>
                    </li>
                </ul>

                <div class="cta-buttons">
                    <button class="btn btn-start">Start now</button>
                    <button class="btn btn-learn">Learn more</button>
                </div>
            </div>

            
        </div>
    </div>
    </div>
</div>

@endsection