<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\TeamMember;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function calendarEvents(Request $request)
{
    $storeId = auth()->guard('store')->user()->id;

    $start = $request->start ? Carbon::parse($request->start) : Carbon::today()->startOfMonth();
    $end = $request->end ? Carbon::parse($request->end) : Carbon::today()->endOfMonth();

    $appointments = Appointment::with(['teamMember', 'service'])
        ->where('store_id', $storeId)
        ->whereBetween('appointment_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
        ->get()
        ->map(function ($appointment) {
            $date = Carbon::parse($appointment->appointment_date);
            
            $teamMember = $appointment->teamMember->full_name ?? 'N/A';
            $serviceName = $appointment->service->name ?? 'N/A';

            // Use team member's calendar color as the main color
            $color = $appointment->teamMember->calendar_color ?? '#3B82F6';
            
            // Optional: You can still keep status-based styling for borders
            $statusBorderColor = match($appointment->status) {
                'scheduled' => '#3B82F6',
                'confirmed' => '#10B981',
                'completed' => '#6B7280',
                'cancelled' => '#EF4444',
                'no_show' => '#F59E0B',
                default => '#3B82F6'
            };

            return [
                'id' => $appointment->id,
                'title' => $appointment->client_name . ' - ' . $serviceName,
                'start' => $date->format('Y-m-d') . 'T' . $appointment->start_time->format('H:i:s'),
                'end' => $date->format('Y-m-d') . 'T' . $appointment->end_time->format('H:i:s'),
                'color' => $color, // Main color from team member
                'textColor' => '#ffffff', // Ensure text is readable
                'extendedProps' => [
                    'team_member' => $teamMember,
                    'service' => $serviceName,
                    'status' => $appointment->status,
                    'price' => $appointment->price,
                    'team_member_id' => $appointment->team_member_id,
                    'status_border_color' => $statusBorderColor, // For optional CSS styling
                ]
            ];
        });

    return response()->json($appointments);
}
  
public function calendarEvents_22(Request $request)
{
    $storeId = auth()->guard('store')->user()->id;

    $start = $request->start ? Carbon::parse($request->start) : Carbon::today()->startOfMonth();
    $end = $request->end ? Carbon::parse($request->end) : Carbon::today()->endOfMonth();

    $appointments = Appointment::with(['teamMember', 'service'])
        ->where('store_id', $storeId)
        ->whereBetween('appointment_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
        ->get()
        ->map(function ($appointment) {
            // Parse appointment date
            $date = Carbon::parse($appointment->appointment_date);
            
             

            $teamMember = $appointment->teamMember->full_name ?? 'N/A';
            $serviceName = $appointment->service->name ?? 'N/A';

            $color = match($appointment->status) {
                'scheduled' => '#3B82F6',
                'confirmed' => '#10B981',
                'completed' => '#6B7280',
                'cancelled' => '#EF4444',
                'no_show' => '#F59E0B',
                default => '#3B82F6'
            };

            return [
                'id' => $appointment->id,
                'title' => $appointment->client_name . ' - ' . $serviceName,
                'start' => $date->format('Y-m-d') . 'T' .$appointment->start_time->format('H:i:s'),
                'end' => $date->format('Y-m-d') . 'T' . $appointment->end_time->format('H:i:s'),
                'color' => $color,
                'extendedProps' => [
                    'team_member' => $teamMember,
                    'service' => $serviceName,
                    'status' => $appointment->status,
                    'price' => $appointment->price,
                ]
            ];
        });

    return response()->json($appointments);
}
    


    public function teamMemberSchedule(Request $request, TeamMember $teamMember)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();

        $schedule = [
            'shifts' => $teamMember->scheduledShifts()
                ->where('shift_date', $date->format('Y-m-d'))
                ->get()
                ->map(function ($shift) {
                    return [
                        'start' => $shift->start_time,
                        'end' => $shift->end_time,
                        'type' => $shift->shift_type,
                    ];
                }),
            'appointments' => $teamMember->appointments()
                ->with('service')
                ->where('appointment_date', $date->format('Y-m-d'))
                ->whereIn('status', ['scheduled', 'confirmed'])
                ->get()
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'client_name' => $appointment->client_name,
                        'service' => $appointment->service->name,
                        'start' => $appointment->start_time,
                        'end' => $appointment->end_time,
                        'status' => $appointment->status,
                    ];
                })
        ];

        return response()->json($schedule);
    }
}