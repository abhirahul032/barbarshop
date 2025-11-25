<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $storeId = auth()->guard('store')->user()->id;
        
        $appointments = Appointment::with(['teamMember', 'service'])
            ->where('store_id', $storeId)
            ->when($request->date, function ($query, $date) {
                return $query->where('appointment_date', $date);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->team_member_id, function ($query, $teamMemberId) {
                return $query->where('team_member_id', $teamMemberId);
            })
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->paginate(20);

        $teamMembers = TeamMember::where('store_id', $storeId)
            ->where('is_active', true)
            ->get();

        return view('store.appointments.index', compact('appointments', 'teamMembers'));
    }

    public function calendar(Request $request)
    {
        $storeId = auth()->guard('store')->user()->id;
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();
        
        $teamMembers = TeamMember::with(['appointments' => function ($query) use ($date) {
            $query->where('appointment_date', $date->format('Y-m-d'))
                  ->whereIn('status', ['scheduled', 'confirmed']);
        }, 'appointments.service', 'scheduledShifts' => function ($query) use ($date) {
            $query->where('shift_date', $date->format('Y-m-d'));
        }])
        ->where('store_id', $storeId)
        ->where('is_active', true)
        ->get();

        $services = Service::where('store_id', $storeId)
            ->where('is_active', true)
            ->get()
            ->groupBy('category');

        return view('store.appointments.calendar', compact('teamMembers', 'services', 'date'));
    }

    public function create()
    {
        $storeId = auth()->guard('store')->user()->id;        
        $teamMembers = TeamMember::where('store_id', $storeId)
            ->where('is_active', true)
            ->where('allow_bookings', true)
            ->get();

        $services = Service::where('store_id', $storeId)
            ->where('is_active', true)
            ->get()
            ->groupBy('category');

        return view('store.appointments.create', compact('teamMembers', 'services'));
    }

    public function store(Request $request)
    {
        $storeId = auth()->guard('store')->user()->id;
        
        $validated = $request->validate([
            'team_member_id' => 'required|exists:team_members,id',
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'client_notes' => 'nullable|string',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $teamMember = TeamMember::findOrFail($validated['team_member_id']);
        
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Check availability
        if (!$teamMember->isAvailableAt($validated['appointment_date'], $startTime->format('H:i:s'), $endTime->format('H:i:s'))) {
            return back()->withErrors(['start_time' => 'The selected time slot is not available.'])->withInput();
        }

        $appointment = Appointment::create([
            'store_id' => $storeId,
            'team_member_id' => $validated['team_member_id'],
            'service_id' => $validated['service_id'],
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
            'client_notes' => $validated['client_notes'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'price' => $service->price,
            'notes' => $validated['notes'],
            'status' => 'scheduled',
        ]);

        // Calculate commission
        $this->calculateCommission($appointment);

        return redirect()->route('store.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        // Ensure the appointment belongs to the current store
        if ($appointment->store_id !== auth()->guard('store')->user()->id) {
            abort(403);
        }
        
        $appointment->load(['teamMember', 'service', 'store']);
          // Add formatted time attributes for JSON response
    $appointment->formatted_start_time = $appointment->getFormattedStartTimeAttribute();
    $appointment->formatted_end_time = $appointment->getFormattedEndTimeAttribute();
    
    if (request()->wantsJson()) {
        return response()->json($appointment);
    }
        
        return view('store.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        // Ensure the appointment belongs to the current store
        if ($appointment->store_id !== auth()->guard('store')->user()->id) {
            abort(403);
        }
        
        $storeId = $appointment->store_id;
        
        $teamMembers = TeamMember::where('store_id', $storeId)
            ->where('is_active', true)
            ->where('allow_bookings', true)
            ->get();

        $services = Service::where('store_id', $storeId)
            ->where('is_active', true)
            ->get()
            ->groupBy('category');

        return view('store.appointments.edit', compact('appointment', 'teamMembers', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the current store
        if ($appointment->store_id !== auth()->guard('store')->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'team_member_id' => 'required|exists:team_members,id',
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'client_notes' => 'nullable|string',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $teamMember = TeamMember::findOrFail($validated['team_member_id']);
        
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Check availability (excluding current appointment)
        if (!$teamMember->isAvailableAt($validated['appointment_date'], $startTime->format('H:i:s'), $endTime->format('H:i:s'), $appointment->id)) {
            return back()->withErrors(['start_time' => 'The selected time slot is not available.'])->withInput();
        }

        $appointment->update([
            'team_member_id' => $validated['team_member_id'],
            'service_id' => $validated['service_id'],
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
            'client_notes' => $validated['client_notes'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'status' => $validated['status'],
            'price' => $service->price,
            'notes' => $validated['notes'],
        ]);

        // Recalculate commission if service or team member changed
        if ($appointment->wasChanged(['service_id', 'team_member_id'])) {
            $this->calculateCommission($appointment);
        }

        return redirect()->route('store.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        // Ensure the appointment belongs to the current store
        if ($appointment->store_id !== auth()->guard('store')->user()->id) {
            abort(403);
        }

        $appointment->delete();

        return redirect()->route('store.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    public function getAvailableSlots(Request $request)
    {
        $storeId = auth()->guard('store')->user()->id;
        
        $request->validate([
            'team_member_id' => 'required|exists:team_members,id',
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
        ]);

        $teamMember = TeamMember::findOrFail($request->team_member_id);
        
        // Ensure team member belongs to current store
        if ($teamMember->store_id !== $storeId) {
            abort(403);
        }
        
        $service = Service::findOrFail($request->service_id);

        $slots = $teamMember->getAvailableSlots($request->date, $service->duration_minutes);

        return response()->json($slots);
    }

    private function calculateCommission(Appointment $appointment): void
    {
        $commission = $appointment->teamMember->commission;
        
        if (!$commission || !$commission->services_commission_enabled) {
            $appointment->update(['commission_amount' => 0]);
            return;
        }

        $rate = $commission->services_default_rate;
        
        // Check for service-specific override
        $override = $commission->overrides()
            ->where('type', 'service')
            ->where('item_id', $appointment->service_id)
            ->first();

        if ($override) {
            $rate = $override->rate;
        }

        $commissionAmount = $commission->services_commission_type === 'percentage' 
            ? ($appointment->price * $rate / 100)
            : $rate;

        $appointment->update(['commission_amount' => $commissionAmount]);
    }
}