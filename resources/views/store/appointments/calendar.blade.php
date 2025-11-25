@extends('store.layouts.app')

@section('title', 'Appointment Calendar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Appointment Calendar</h5>
                    <div class="d-flex align-items-center">
                        <!-- Team Member Legend -->
                        <div class="me-3" id="teamMemberLegend">
                            <!-- Legend will be populated by JavaScript -->
                        </div>
                        <a href="{{ route('store.appointments.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> New Appointment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Details Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="appointmentDetails">
                    <!-- Appointment details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="editAppointmentBtn" class="btn btn-primary">Edit Appointment</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<style>
    #calendar {
        background-color: white;
        border-radius: 0.375rem;
        padding: 1rem;
    }
    
    .fc-event {
        cursor: pointer;
        border: none;
        font-size: 0.875rem;
        padding: 2px 4px;
    }
    
    .fc-day-today {
        background-color: rgba(59, 130, 246, 0.1) !important;
    }
    
    .appointment-details p {
        margin-bottom: 0.5rem;
    }
    
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    /* Team Member Legend Styles */
    .team-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.875rem;
    }
    
    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 3px;
        display: inline-block;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var teamMembers = {};
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: {
            url: '{{ route("store.api.calendar-events") }}',
            method: 'GET',
            failure: function() {
                alert('There was an error while fetching events!');
            },
            success: function(events) {
                // Build team member legend from events
                buildTeamMemberLegend(events);
            }
        },
        eventDidMount: function(info) {
            // Add team member name as tooltip
            if (info.event.extendedProps.team_member) {
                info.el.title = info.event.extendedProps.team_member + ' - ' + info.event.title;
            }
            
            // Add status indicator as border or dot
            var status = info.event.extendedProps.status;
            var statusColor = getStatusColor(status);
            
            // Add a small status indicator (you can customize this)
            info.el.style.borderLeft = `3px solid ${statusColor}`;
        },
        eventClick: function(info) {
            var event = info.event;
            
            // Load appointment details via AJAX
            fetch(url_front +`store/appointments/${event.id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(appointment => {
                    // Format the appointment details
                    var statusClass = {
                        'scheduled': 'bg-primary',
                        'confirmed': 'bg-success',
                        'completed': 'bg-secondary',
                        'cancelled': 'bg-danger',
                        'no_show': 'bg-warning'
                    }[appointment.status] || 'bg-primary';
                    
                    var detailsHtml = `
                        <div class="appointment-details">
                            <p><strong>Client:</strong> ${appointment.client_name}</p>
                            <p><strong>Service:</strong> ${appointment.service.name}</p>
                            <p><strong>Team Member:</strong> 
                                <span class="badge" style="background-color: ${event.backgroundColor}; color: white; padding: 0.25rem 0.5rem;">
                                    ${appointment.team_member.full_name}
                                </span>
                            </p>
                            <p><strong>Date & Time:</strong> ${appointment.formatted_start_time} - ${appointment.formatted_end_time}</p>
                            <p><strong>Status:</strong> <span class="badge ${statusClass} status-badge">${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)}</span></p>
                            <p><strong>Price:</strong> $${parseFloat(appointment.price).toFixed(2)}</p>
                            ${appointment.notes ? `<p><strong>Notes:</strong> ${appointment.notes}</p>` : ''}
                            ${appointment.client_notes ? `<p><strong>Client Notes:</strong> ${appointment.client_notes}</p>` : ''}
                        </div>
                    `;
                    
                    document.getElementById('appointmentDetails').innerHTML = detailsHtml;
                    document.getElementById('editAppointmentBtn').href = `/store/appointments/${appointment.id}/edit`;
                    
                    var modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error loading appointment details:', error);
                    alert('Error loading appointment details');
                });
        },
        dateClick: function(info) {
            // Redirect to create appointment with selected date
            window.location.href = '{{ route("store.appointments.create") }}?date=' + info.dateStr;
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        },
        slotMinTime: '06:00:00',
        slotMaxTime: '22:00:00',
        businessHours: {
            daysOfWeek: [1, 2, 3, 4, 5, 6],
            startTime: '09:00',
            endTime: '18:00',
        },
        nowIndicator: true,
        navLinks: true,
        editable: false,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        timeZone: 'local'
    });

    calendar.render();

    // Function to build team member legend
    function buildTeamMemberLegend(events) {
        var legendContainer = document.getElementById('teamMemberLegend');
        var legendItems = {};
        
        events.forEach(function(event) {
            var teamMember = event.extendedProps.team_member;
            var teamMemberId = event.extendedProps.team_member_id;
            var color = event.color;
            
            if (teamMember && !legendItems[teamMemberId]) {
                legendItems[teamMemberId] = {
                    name: teamMember,
                    color: color
                };
            }
        });
        
        if (Object.keys(legendItems).length > 0) {
            var legendHtml = '<div class="team-legend">';
            legendHtml += '<strong class="me-2">Team Members:</strong>';
            
            Object.values(legendItems).forEach(function(member) {
                legendHtml += `
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: ${member.color}"></span>
                        <span>${member.name}</span>
                    </div>
                `;
            });
            
            legendHtml += '</div>';
            legendContainer.innerHTML = legendHtml;
        }
    }

    // Function to get status color for borders
    function getStatusColor(status) {
        var statusColors = {
            'scheduled': '#3B82F6',
            'confirmed': '#10B981',
            'completed': '#6B7280',
            'cancelled': '#EF4444',
            'no_show': '#F59E0B'
        };
        return statusColors[status] || '#3B82F6';
    }
});
</script>
@endpush