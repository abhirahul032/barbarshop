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
        
        return response()->json([
            'success' => true,
            'data' => $scheduledShift
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
}