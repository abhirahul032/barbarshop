@extends('store.layouts.app')

@section('title', 'Scheduled Shifts')

@section('content')
 <style>
       
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            margin: 0;
        }
        
        .header-actions {
            display: flex;
            gap: 0.75rem;
        }
        
        .btn-options {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-options:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .btn-add {
            background: #212529;
            color: white;
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-add:hover {
            background: #000;
            color: white;
        }
        
        .week-navigation {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        
        .week-selector {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .week-nav-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #212529;
        }
        
        .week-nav-btn:hover {
            background: #f8f9fa;
        }
        
        .week-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .week-label {
            font-weight: 500;
            color: #212529;
        }
        
        .week-dates {
            color: #6b7280;
        }
        
        .schedule-table {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .table-header {
            display: grid;
            grid-template-columns: 250px repeat(7, 1fr);
            border-bottom: 2px solid #e5e7eb;
        }
        
        .header-cell {
            padding: 1rem;
            text-align: center;
            border-right: 1px solid #e5e7eb;
        }
        
        .header-cell:first-child {
            text-align: left;
            padding-left: 1.5rem;
        }
        
        .header-cell:last-child {
            border-right: none;
        }
        
        .day-label {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        
        .day-hours {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .team-label {
            font-weight: 500;
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .change-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            margin-left: 0.5rem;
        }
        
        .change-link:hover {
            text-decoration: underline;
        }
        
        .schedule-row {
            display: grid;
            grid-template-columns: 250px repeat(7, 1fr);
            border-bottom: 1px solid #e5e7eb;
        }
        
        .schedule-row:last-child {
            border-bottom: none;
        }
        
        .member-cell {
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-right: 1px solid #e5e7eb;
        }
        
        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .member-info {
            flex: 1;
        }
        
        .member-name {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
            margin-bottom: 0.125rem;
        }
        
        .member-hours {
            color: #6b7280;
            font-size: 0.8rem;
        }
        
        .edit-icon {
            color: #6b7280;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .edit-icon:hover {
            color: #212529;
        }
        
        .shift-cell {
            padding: 1.25rem 1rem;
            text-align: center;
            border-right: 1px solid #e5e7eb;
            background: #fafbfc;
            font-size: 0.875rem;
            color: #374151;
        }
        
        .shift-cell:last-child {
            border-right: none;
        }
        
        .shift-cell.empty {
            background: white;
        }
        
        .info-banner {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        
        .info-icon {
            color: #3b82f6;
            font-size: 1.25rem;
            flex-shrink: 0;
            margin-top: 0.125rem;
        }
        
        .info-text {
            color: #1e40af;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        
        .info-text a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }
        
        .info-text a:hover {
            text-decoration: underline;
        }
        
        .avatar-rahul {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .avatar-wendy {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }
        
        @media (max-width: 1200px) {
            .schedule-table {
                overflow-x: auto;
            }
            
            .table-header,
            .schedule-row {
                min-width: 1000px;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Scheduled Shifts</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Scheduled Shifts</li>
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
           <div class="coner-fluid" style="">
        <div class="page-header">
            <h1 class="page-title">Scheduled shifts</h1>
            <div class="header-actions">
                <button class="btn btn-options">
                    Options
                    <i class="bi bi-chevron-down"></i>
                </button>
                <button class="btn btn-add">
                    Add
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
        </div>

        <div class="week-navigation">
            <div class="week-selector">
                <button class="week-nav-btn">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="week-info">
                    <span class="week-label">This week</span>
                    <span class="week-dates">17 - 23 Nov, 2025</span>
                </div>
                <button class="week-nav-btn">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="schedule-table">
            <div class="table-header">
                <div class="header-cell">
                    <span class="team-label">Team member</span>
                    <a href="#" class="change-link">Change</a>
                </div>
                <div class="header-cell">
                    <div class="day-label">Mon, 17 Nov</div>
                    <div class="day-hours">18h</div>
                </div>
                <div class="header-cell">
                    <div class="day-label">Tue, 18 Nov</div>
                    <div class="day-hours">18h</div>
                </div>
                <div class="header-cell">
                    <div class="day-label">Wed, 19 Nov</div>
                    <div class="day-hours">18h</div>
                </div>
                <div class="header-cell">
                    <div class="day-label">Thu, 20 Nov</div>
                    <div class="day-hours">18h</div>
                </div>
                <div class="header-cell">
                    <div class="day-label">Fri, 21 Nov</div>
                    <div class="day-hours">18h</div>
                </div>
                <div class="header-cell">
                    <div class="day-label">Sat, 22 Nov</div>
                    <div class="day-hours">14h</div>
                </div>
                <div class="header-cell">
                    <div class="day-label">Sun, 23 Nov</div>
                    <div class="day-hours">0min</div>
                </div>
            </div>

            <div class="schedule-row">
                <div class="member-cell">
                    <div class="member-avatar avatar-rahul">
                        RS
                    </div>
                    <div class="member-info">
                        <div class="member-name">RAHUL SHARMA</div>
                        <div class="member-hours">52h</div>
                    </div>
                    <i class="bi bi-pencil edit-icon"></i>
                </div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 5pm</div>
                <div class="shift-cell empty"></div>
            </div>

            <div class="schedule-row">
                <div class="member-cell">
                    <div class="member-avatar avatar-wendy">
                        WS
                    </div>
                    <div class="member-info">
                        <div class="member-name">Wendy Smith...</div>
                        <div class="member-hours">52h</div>
                    </div>
                    <i class="bi bi-pencil edit-icon"></i>
                </div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 7pm</div>
                <div class="shift-cell">10am - 5pm</div>
                <div class="shift-cell empty"></div>
            </div>
        </div>

        <div class="info-banner">
            <i class="bi bi-info-circle info-icon"></i>
            <div class="info-text">
                The team roster shows your availability for bookings and is not linked to your business standard opening hours. To set your standard opening hours, <a href="#">click here</a>.
            </div>
        </div>
    </div>
    </div>
</div>

@endsection