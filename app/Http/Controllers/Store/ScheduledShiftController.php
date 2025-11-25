<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\ScheduledShift;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ScheduledShiftController extends Controller
{
    
    public function index(Request $request)
{
    $storeId = auth()->guard('store')->user()->id;
    
    // Get the week from request or default to current week
    $weekStart = $request->get('week_start') 
        ? Carbon::parse($request->get('week_start'))
        : Carbon::now()->startOfWeek();
        
    $weekEnd = $weekStart->copy()->endOfWeek();

    // Debug: Check the date range
    \Log::info("Fetching shifts for week: {$weekStart->format('Y-m-d')} to {$weekEnd->format('Y-m-d')}");

    // Get all active team members
    $teamMembers = TeamMember::where('store_id', $storeId)
               ->where('is_active', true)
               ->get();

    // Create default shifts for team members who don't have shifts for working days
    $this->createDefaultShiftsForTeamMembers($teamMembers, $weekStart);

    // Now load team members with their shifts (including newly created ones)
    $teamMembers = TeamMember::with(['scheduledShifts' => function($query) use ($weekStart, $weekEnd) {
        $query->whereBetween('shift_date', [$weekStart, $weekEnd])
              ->orderBy('shift_date')
              ->orderBy('start_time');
    }])->where('store_id', $storeId)
       ->where('is_active', true)
       ->get();

    // Debug: Check what shifts are being loaded
    foreach ($teamMembers as $member) {
        \Log::info("Team Member {$member->id}: {$member->first_name} has " . $member->scheduledShifts->count() . " shifts");
        foreach ($member->scheduledShifts as $shift) {
            \Log::info("Shift: {$shift->shift_date} {$shift->start_time}-{$shift->end_time}");
        }
    }

    // Generate all week days for display (Monday to Sunday)
    $weekDays = [];
    for ($i = 0; $i < 7; $i++) {
        $weekDays[] = $weekStart->copy()->addDays($i);
    }

    return view('store.scheduled-shifts.index', compact('teamMembers', 'weekDays', 'weekStart', 'weekEnd'));
}

/**
 * Create default shifts for team members who don't have shifts for working days
 */
private function createDefaultShiftsForTeamMembers($teamMembers, Carbon $weekStart): void
{
    $workingDays = $this->getWorkingDays($weekStart);
    $defaultTimes = $this->getDefaultShiftTimes();

    foreach ($teamMembers as $member) {
        $this->createMissingShiftsForMember($member, $workingDays, $defaultTimes);
    }
}

/**
 * Get working days for the week (Monday to Friday)
 */
private function getWorkingDays(Carbon $weekStart): array
{
    $workingDays = [];
    for ($i = 0; $i < 6; $i++) {
        $workingDays[] = $weekStart->copy()->addDays($i);
    }
    return $workingDays;
}

/**
 * Get default shift times
 */
private function getDefaultShiftTimes(): array
{
    return [
        'start_time' => '09:00',
        'end_time' => '19:00',
        'shift_type' => 'regular',
        'notes' => 'Auto-generated default shift'
    ];
}

/**
 * Create missing shifts for a specific team member
 */
private function createMissingShiftsForMember(TeamMember $member, array $workingDays, array $defaultTimes): void
{
    foreach ($workingDays as $day) {
        $shiftDate = $day->format('Y-m-d');
        
        // Check if shift already exists for this day
        $existingShift = ScheduledShift::where('team_member_id', $member->id)
            ->where('shift_date', $shiftDate)
            ->first();

        // If no shift exists, create a default one
        if (!$existingShift) {
            ScheduledShift::create([
                'team_member_id' => $member->id,
                'shift_date' => $shiftDate,
                'start_time' => $defaultTimes['start_time'],
                'end_time' => $defaultTimes['end_time'],
                'shift_type' => $defaultTimes['shift_type'],
                'notes' => $defaultTimes['notes'],
            ]);
            
            \Log::info("Created default shift for {$member->first_name} on {$shiftDate}");
        }
    }
}
    
    public function index_old(Request $request)
    {
        $storeId = auth()->guard('store')->user()->id;
        
        // Get the week from request or default to current week
        $weekStart = $request->get('week_start') 
            ? Carbon::parse($request->get('week_start'))
            : Carbon::now()->startOfWeek();
            
        $weekEnd = $weekStart->copy()->endOfWeek();

        // Debug: Check the date range
        \Log::info("Fetching shifts for week: {$weekStart->format('Y-m-d')} to {$weekEnd->format('Y-m-d')}");

        $teamMembers = TeamMember::with(['scheduledShifts' => function($query) use ($weekStart, $weekEnd) {
            $query->whereBetween('shift_date', [$weekStart, $weekEnd])
                  ->orderBy('shift_date')
                  ->orderBy('start_time');
        }])->where('store_id', $storeId)
           ->where('is_active', true)
           ->get();

        // Debug: Check what shifts are being loaded
        foreach ($teamMembers as $member) {
            \Log::info("Team Member {$member->id}: {$member->first_name} has " . $member->scheduledShifts->count() . " shifts");
            foreach ($member->scheduledShifts as $shift) {
                \Log::info("Shift: {$shift->shift_date} {$shift->start_time}-{$shift->end_time}");
            }
        }

        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $weekDays[] = $weekStart->copy()->addDays($i);
        }

        return view('store.scheduled-shifts.index', compact('teamMembers', 'weekDays', 'weekStart', 'weekEnd'));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'team_member_id' => 'required|exists:team_members,id',
                'shift_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'shift_type' => 'required|in:regular,overtime,holiday',
                'notes' => 'nullable|string',
                'is_repeating' => 'boolean',
                'repeat_frequency' => 'nullable|in:weekly,bi_weekly,monthly',
                'repeat_until' => 'nullable|date|after:shift_date',
            ]);

            $shift = ScheduledShift::create($validated);

            // If it's a repeating shift, create future shifts
            if ($request->boolean('is_repeating') && $request->repeat_frequency && $request->repeat_until) {
                $this->createRepeatingShifts($shift, $request->repeat_frequency, $request->repeat_until);
            }

            return response()->json([
                'success' => true,
                'message' => 'Shift scheduled successfully',
                'data' => $shift->load('teamMember')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Failed to schedule shift: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to schedule shift: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, ScheduledShift $scheduledShift): JsonResponse
    {
        try {
            $this->authorizeShift($scheduledShift);

            $validated = $request->validate([
                'shift_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'shift_type' => 'required|in:regular,overtime,holiday',
                'notes' => 'nullable|string',
            ]);

            $scheduledShift->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Shift updated successfully',
                'data' => $scheduledShift->load('teamMember')
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to update shift: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update shift: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(ScheduledShift $scheduledShift): JsonResponse
    {
        try {
            $this->authorizeShift($scheduledShift);
            
            // Format the times to ensure they work with HTML time inputs
            $formattedShift = [
                'id' => $scheduledShift->id,
                'shift_date' => $scheduledShift->shift_date,
                'start_time' => $this->formatTimeForHtml($scheduledShift->start_time),
                'end_time' => $this->formatTimeForHtml($scheduledShift->end_time),
                'shift_type' => $scheduledShift->shift_type,
                'notes' => $scheduledShift->notes,
            ];

            \Log::info('Formatted shift data for edit:', $formattedShift);
            
            return response()->json([
                'success' => true,
                'data' => $formattedShift
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to fetch shift data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch shift data: ' . $e->getMessage()
            ], 500);
        }
    }

    // The destroy method you already have:
    public function destroy(ScheduledShift $scheduledShift): JsonResponse
    {
        try {
            $this->authorizeShift($scheduledShift);
            
            $scheduledShift->delete();

            return response()->json([
                'success' => true,
                'message' => 'Shift deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to delete shift: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete shift: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkStore(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'team_member_ids' => 'required|array',
                'team_member_ids.*' => 'exists:team_members,id',
                'shift_dates' => 'required|array',
                'shift_dates.*' => 'date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'shift_type' => 'required|in:regular,overtime,holiday',
            ]);

            $shifts = [];
            foreach ($validated['team_member_ids'] as $teamMemberId) {
                foreach ($validated['shift_dates'] as $shiftDate) {
                    $shifts[] = ScheduledShift::create([
                        'team_member_id' => $teamMemberId,
                        'shift_date' => $shiftDate,
                        'start_time' => $validated['start_time'],
                        'end_time' => $validated['end_time'],
                        'shift_type' => $validated['shift_type'],
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Shifts scheduled successfully',
                'data' => $shifts
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to schedule bulk shifts: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to schedule shifts: ' . $e->getMessage()
            ], 500);
        }
    }

    private function createRepeatingShifts(ScheduledShift $originalShift, string $frequency, string $repeatUntil)
    {
        $currentDate = Carbon::parse($originalShift->shift_date);
        $endDate = Carbon::parse($repeatUntil);
        
        while ($currentDate->lte($endDate)) {
            // Skip the original shift date
            $currentDate = $this->getNextDate($currentDate, $frequency);
            
            if ($currentDate->lte($endDate)) {
                ScheduledShift::create([
                    'team_member_id' => $originalShift->team_member_id,
                    'shift_date' => $currentDate->format('Y-m-d'),
                    'start_time' => $originalShift->start_time,
                    'end_time' => $originalShift->end_time,
                    'shift_type' => $originalShift->shift_type,
                    'notes' => $originalShift->notes,
                    'is_repeating' => true,
                    'repeat_frequency' => $frequency,
                ]);
            }
        }
    }

    private function getNextDate(Carbon $currentDate, string $frequency): Carbon
    {
        return match($frequency) {
            'weekly' => $currentDate->addWeek(),
            'bi_weekly' => $currentDate->addWeeks(2),
            'monthly' => $currentDate->addMonth(),
            default => $currentDate->addWeek(),
        };
    }

    private function authorizeShift(ScheduledShift $scheduledShift)
    {
        $storeId = auth()->guard('store')->user()->id;
        if ($scheduledShift->teamMember->store_id !== $storeId) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Format time for HTML time input (HH:MM)
     */
    private function formatTimeForHtml($time): string
    {
        if (empty($time)) {
            return '';
        }

        // If it's already in HH:MM format
        if (preg_match('/^\d{1,2}:\d{2}$/', $time)) {
            // Ensure 2-digit hour
            $parts = explode(':', $time);
            return sprintf('%02d:%s', $parts[0], $parts[1]);
        }

        // If it's in HH:MM:SS format
        if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $time)) {
            $parts = explode(':', $time);
            return sprintf('%02d:%s', $parts[0], $parts[1]);
        }

        // If it's a Carbon instance or DateTime
        if ($time instanceof \Carbon\Carbon || $time instanceof \DateTime) {
            return $time->format('H:i');
        }

        // Try to parse as time
        try {
            $carbonTime = Carbon::parse($time);
            return $carbonTime->format('H:i');
        } catch (\Exception $e) {
            \Log::warning("Could not parse time: {$time}");
            return '';
        }
    }
}