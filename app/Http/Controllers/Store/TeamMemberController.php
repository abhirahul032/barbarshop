<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller; // Add this import
use App\Models\TeamMember;
use App\Models\Store;
use App\Models\Service;
use App\Models\Address;
use App\Models\EmergencyContact;
use App\Models\Country;
use App\Models\Wage;
use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\PayRun;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
class TeamMemberController extends Controller // Now this will work
{
    
    public function storePayRun(Request $request, $teamMemberId): JsonResponse
    {
        try {
            $validated = $request->validate([
                // Preferred Payment Method
                'preferred_payment_method' => 'required|in:manual,bank_transfer,cash,check',
                
                // Calculation of Pay Runs
                'pay_calculation' => 'required|in:automatic,manual',
                
                // Pay Run Deductions
                'deduct_processing_fees' => 'boolean',
                'deduct_client_fees' => 'boolean',
                'processing_fee_percentage' => 'required_if:deduct_processing_fees,1|numeric|min:0|max:100',
                'client_fee_percentage' => 'required_if:deduct_client_fees,1|numeric|min:0|max:100',
                
                // Cash Advances
                'record_cash_advances' => 'boolean',
                'auto_record_cash_payments' => 'boolean',
                
                // Pay Run Schedule
                'pay_frequency' => 'required|in:weekly,bi_weekly,monthly,semi_monthly',
                'pay_schedule' => 'nullable|string|max:255',
                'next_pay_date' => 'nullable|date',
                
                // Additional Settings
                'include_commissions' => 'boolean',
                'include_tips' => 'boolean',
                'include_bonuses' => 'boolean',
                'auto_generate_pay_runs' => 'boolean',
            ]);

            $teamMember = TeamMember::findOrFail($teamMemberId);
            
            $payRun = PayRun::updateOrCreate(
                ['team_member_id' => $teamMember->id],
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Pay run settings saved successfully',
                'data' => $payRun
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Failed to save pay run settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save pay run settings: ' . $e->getMessage()
            ], 500);
        }
    }
     // Method to generate pay run
    public function generatePayRun(Request $request, $teamMemberId): JsonResponse
    {
        try {
            $teamMember = TeamMember::findOrFail($teamMemberId);
            
            // Calculate earnings based on period
            $payRunData = $this->calculatePayRun($teamMember, $request->pay_period_start, $request->pay_period_end);
            
            $payRunHistory = PayRunHistory::create([
                'team_member_id' => $teamMember->id,
                'pay_period_start' => $request->pay_period_start,
                'pay_period_end' => $request->pay_period_end,
                'pay_date' => $request->pay_date ?? now()->addDays(7),
                ...$payRunData
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pay run generated successfully',
                'data' => $payRunHistory
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to generate pay run: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate pay run: ' . $e->getMessage()
            ], 500);
        }
    }

    private function calculatePayRun($teamMember, $startDate, $endDate)
    {
        // This is a simplified calculation - you would integrate with your actual business logic
        $baseWages = 0;
        $overtimeWages = 0;
        $commissions = 0;
        $tips = 0;
        $bonuses = 0;
        $processingFees = 0;
        $clientFees = 0;

        // Calculate based on team member's wage settings, commissions, etc.
        // This would integrate with your timesheets, sales, and commission data
        
        $totalEarnings = $baseWages + $overtimeWages + $commissions + $tips + $bonuses;
        $deductions = $processingFees + $clientFees;
        $netPay = $totalEarnings - $deductions;

        return [
            'total_earnings' => $totalEarnings,
            'base_wages' => $baseWages,
            'overtime_wages' => $overtimeWages,
            'commissions' => $commissions,
            'tips' => $tips,
            'bonuses' => $bonuses,
            'deductions' => $deductions,
            'processing_fees' => $processingFees,
            'client_fees' => $clientFees,
            'net_pay' => $netPay,
            'payment_method' => $teamMember->payRun->preferred_payment_method ?? 'manual',
            'status' => 'draft',
        ];
    }
    public function index()
    {
        $storeId = auth()->guard('store')->user()->id;
        $teamMembers = TeamMember::with(['addresses', 'emergencyContacts', 'services', 'locations'])
            ->where('store_id', $storeId)
            ->get();

        return view('store.team-members.index', compact('teamMembers'));
    }

    public function create()
    {
        $storeId = auth()->guard('store')->user()->id;
        $services = Service::where('store_id', $storeId)->where('is_active', true)->get();
        $locations = Store::where('id', $storeId)->get();
        $countries=Country::all();
        
        
        return view('store.team-members.create', compact('services', 'locations','countries'));
    }
     public function storeCommission(Request $request, $teamMemberId): JsonResponse
    {
        try {
            $validated = $request->validate([
                // Services Commission
                'services_commission_enabled' => 'boolean',
                'services_commission_type' => 'required_if:services_commission_enabled,1|in:fixed_rate,percentage',
                'services_default_rate' => 'required_if:services_commission_enabled,1|numeric|min:0',
                'services_calculation_type' => 'required_if:services_commission_enabled,1|in:default,custom',
                
                // Products Commission
                'products_commission_enabled' => 'boolean',
                'products_commission_type' => 'required_if:products_commission_enabled,1|in:fixed_rate,percentage',
                'products_default_rate' => 'required_if:products_commission_enabled,1|numeric|min:0',
                'products_calculation_type' => 'required_if:products_commission_enabled,1|in:default,custom',
                
                // Memberships Commission
                'memberships_commission_enabled' => 'boolean',
                'memberships_commission_type' => 'required_if:memberships_commission_enabled,1|in:fixed_rate,percentage',
                'memberships_default_rate' => 'required_if:memberships_commission_enabled,1|numeric|min:0',
                'memberships_calculation_type' => 'required_if:memberships_commission_enabled,1|in:default,custom',
                'memberships_deduct_discounts' => 'boolean',
                'memberships_deduct_taxes' => 'boolean',
                
                // Gift Cards Commission
                'gift_cards_commission_enabled' => 'boolean',
                'gift_cards_commission_type' => 'required_if:gift_cards_commission_enabled,1|in:fixed_rate,percentage',
                'gift_cards_default_rate' => 'required_if:gift_cards_commission_enabled,1|numeric|min:0',
                'gift_cards_calculation_type' => 'required_if:gift_cards_commission_enabled,1|in:default,custom',
                
                // Cancellation Commission
                'cancellation_commission_enabled' => 'boolean',
                'late_cancellation_fee' => 'boolean',
                'no_show_fee' => 'boolean',
            ]);

            $teamMember = TeamMember::findOrFail($teamMemberId);
            
            $commission = Commission::updateOrCreate(
                ['team_member_id' => $teamMember->id],
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Commission settings saved successfully',
                'data' => $commission
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Failed to save commission settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save commission settings: ' . $e->getMessage()
            ], 500);
        }
    }
public function store(Request $request)
{
     
     $storeId = auth()->guard('store')->user()->id;
    // Manually handle checkbox & calendar_color before validation
    $data = $request->all();

    // Fix checkbox: if not sent → false
    $data['visible_to_clients'] = $request->has('visible_to_clients');

    
    $data['calendar_color'] = $request->filled('calendar_color') 
        ? $request->calendar_color 
        : '#3b82f6'; // default blue if missing

    // Validate cleaned data
    $validated = Validator::make($data, [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('team_members', 'email')
                    ->where(fn($q) => $q->where('store_id', $storeId)),
            ],
        'phone_number' => 'nullable|string|max:20',
        'additional_phone_number' => 'nullable|string|max:20',
        'birthday' => 'nullable|date',
        'country' => 'nullable|string|max:255',
        'job_title' => 'nullable|string|max:255',
        'visible_to_clients' => 'boolean',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after:start_date',
        'employment_type' => 'nullable|in:full_time,part_time,contract,temporary',
        'team_member_id' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'calendar_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/', // strict #RRGGBB
        'services' => 'array',
        'services.*' => 'exists:services,id',
        'locations' => 'array',
        'locations.*' => 'exists:stores,id',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'password' => 'nullable|string|min:8|confirmed',
    ])->validate();

      
    $teamMember = null;
    DB::transaction(function () use ($validated, $request) {
        $storeId = auth()->guard('store')->user()->id;
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('team-photos', 'public');
            $validated['profile_picture'] = $path;
        }

        // Hash password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $teamMember = TeamMember::create(array_merge($validated, [
            'store_id' => $storeId,
        ]));

        // Sync services (empty array = no services)
        $teamMember->services()->sync($request->input('services', []));

        // Sync locations (only one store, but still sync)
        $teamMember->locations()->sync($request->input('locations', []));
    });

//    return redirect()
//        ->route('store.team-members.index')
//        ->with('success', 'Team member created successfully!');
    
      // Redirect to edit page instead of index
    
    
    $teamMember = TeamMember::where('store_id', $storeId)
        ->where('email', $validated['email'])
        ->latest()
        ->first();
    return redirect()
        ->route('store.team-members.edit', $teamMember)
        ->with('success', 'Team member created successfully! You can now add more details.');
    
}
    

    public function show(TeamMember $teamMember)
    {
        // Check if team member belongs to the authenticated store
        $this->authorizeTeamMember($teamMember);
        
        $teamMember->load(['addresses', 'emergencyContacts', 'services', 'locations']);
        return view('store.team-members.show', compact('teamMember'));
    }

    public function edit(TeamMember $teamMember)
    {
        // Check if team member belongs to the authenticated store
        $this->authorizeTeamMember($teamMember);
        
        $storeId = $teamMember->store_id;
        $services = Service::where('store_id', $storeId)->where('is_active', true)->get();
        $locations = Store::where('id', $storeId)->get();
        $countries=Country::all();        
        $teamMember->load(['addresses', 'emergencyContacts', 'services', 'locations']);        
        return view('store.team-members.edit', compact('teamMember', 'services', 'locations','countries'));
    }

    
    /*
    public function updateservices(Request $request, TeamMember $teamMember){
        
        // Validate the services
        $request->validate([
            'services' => 'sometimes|array',
            'services.*' => 'exists:services,id'
        ]);

        // Sync the services (this will attach/detach automatically)
        if ($request->has('services')) {
            $teamMember->services()->sync($request->services);
        } else {
            $teamMember->services()->detach();
        }

        return redirect()->route('store.team-members.edit', $teamMember)
            ->with('success', 'Services updated successfully');
    }
    */
    public function updateSettings(Request $request, TeamMember $teamMember)
            {
                $this->authorizeTeamMember($teamMember);

                // Validate only the settings fields
                $validated = $request->validate([
                    'allow_bookings' => 'boolean',
                    'permission_level' => 'required|in:no_access,low,medium,high,admin',
                ]);

                // Update only the settings fields
                $teamMember->update([
                    'allow_bookings' => $request->has('allow_bookings'),
                    'permission_level' => $request->permission_level,
                ]);

                return redirect()
                    ->route('store.team-members.edit', $teamMember)
                    ->with('success', 'Team member settings updated successfully!');
            }
            public function storewage(Request $request, $teamMemberId): JsonResponse
            {
                $request->validate([
                    'compensation_type' => 'required|in:hourly,salary',
                    'hourly_rate' => 'required_if:compensation_type,hourly|numeric|min:0',
//                    'salary_amount' => 'required_if:compensation_type,salary|numeric|min:0',
//                    'salary_period' => 'required_if:compensation_type,salary|in:monthly,annually',
//                    'overtime_enabled' => 'boolean',
//                    'regular_hours' => 'nullable|numeric|min:0',
//                    'hours_type' => 'nullable|in:per_week,per_month',
//                    'overtime_type' => 'nullable|in:hourly,fixed',
//                    'overtime_rate' => 'nullable|numeric|min:0',
//                    'location_restrictions' => 'required|in:workspace_default,enabled,disabled',
//                    'timesheet_automation' => 'required|in:workspace_default,auto_clock_in,disabled',
//                    'automated_breaks' => 'required|in:workspace_default,enabled,disabled',
//                    'auto_check_out' => 'required|in:workspace_default,enabled,disabled',
                ]);

                try {
                    $teamMember = TeamMember::findOrFail($teamMemberId);

                    // Update or create wage record
                    $wage = Wage::updateOrCreate(
                        ['team_member_id' => $teamMember->id],
                        $request->all()
                    );

                    return response()->json([
                        'success' => true,
                        'message' => 'Wages settings saved successfully',
                        'data' => $wage
                    ]);

                } catch (\Exception $e) {
                    \Log::error('Failed to save wages settings: ' . $e->getMessage());

                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to save wages settings: ' . $e->getMessage()
                    ], 500);
                }
            }
            public function update(Request $request, TeamMember $teamMember){


   

                $this->authorizeTeamMember($teamMember);

                $storeId = auth()->guard('store')->user()->id;

                // === PREPARE DATA BEFORE VALIDATION ===
                $data = $request->all();

                // Fix checkbox
                $data['visible_to_clients'] = $request->has('visible_to_clients');

                // Preserve current calendar color if not provided
                $data['calendar_color'] = $request->filled('calendar_color')
                    ? $request->calendar_color
                    : $teamMember->calendar_color;

                // === MOST IMPORTANT: Force current email if not changed ===
                if (!$request->filled('email')) {
                    $data['email'] = $teamMember->email; // fallback if empty (should never happen, but safe)
                }

                // === VALIDATION WITH PERFECT UNIQUE RULE ===
                $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name'  => 'required|string|max:255',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('team_members', 'email')
                            ->where('store_id', $storeId)
                            ->ignore($teamMember->id),
                    ],
                    'phone_number'            => 'nullable|string|max:20',
                    'additional_phone_number' => 'nullable|string|max:20',
                    'birthday'                => 'nullable|date',
                    'country'                 => 'nullable|string|max:255',
                    'job_title'               => 'nullable|string|max:255',
                    'visible_to_clients'      => 'boolean',
                    'start_date'              => 'nullable|date',
                    'end_date'                => 'nullable|date|after:start_date',
                    'employment_type'         => 'nullable|in:full_time,part_time,contract,temporary',
                    'team_member_id'          => 'nullable|string|max:255',
                    'notes'                   => 'nullable|string',
                    'calendar_color'          => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
                    'services'                => 'nullable|array',
                    'services.*'              => 'exists:services,id',
                    'locations'               => 'nullable|array',
                    'locations.*'             => 'exists:stores,id',
                    'profile_picture'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    'password'                => 'nullable|string|min:8|confirmed',
                ], [], $data); // Pass $data here so validation sees our cleaned version

                // === NOW SAFE TO UPDATE ===
                DB::transaction(function () use ($request, $teamMember, $data) {
                    // Profile picture
                    if ($request->hasFile('profile_picture')) {
                        if ($teamMember->profile_picture) {
                            Storage::disk('public')->delete($teamMember->profile_picture);
                        }
                        $data['profile_picture'] = $request->file('profile_picture')->store('team-photos', 'public');
                    }

                    // Password
                    if ($request->filled('password')) {
                        $data['password'] = Hash::make($request->password);
                    } else {
                        unset($data['password']);
                    }

                    $teamMember->update($data);

                    $teamMember->services()->sync($request->input('services', []));
                    $teamMember->locations()->sync($request->input('locations', []));
                });

                return redirect()
                    ->route('store.team-members.index')
                    ->with('success', 'Team member updated successfully!');
}

    public function destroy(TeamMember $teamMember)
    {
        // Check if team member belongs to the authenticated store
        $this->authorizeTeamMember($teamMember);
        
        $teamMember->delete();
        return redirect()->route('store.team-members.index')->with('success', 'Team member deleted successfully.');
    }
    public function setPrimaryAddress(TeamMember $teamMember, Address $address): JsonResponse
    {
        try {
            $this->authorizeTeamMember($teamMember);

            // Verify the address belongs to the team member
            if ($address->team_member_id !== $teamMember->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            // Remove primary status from all addresses
            $teamMember->addresses()->update(['is_primary' => false]);

            // Set this address as primary
            $address->update(['is_primary' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Primary address updated successfully.',
                'data' => $address
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to set primary address: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to set primary address: ' . $e->getMessage()
            ], 500);
        }
    }
    public function addAddress(Request $request, TeamMember $teamMember): JsonResponse
        {
            try {
                $this->authorizeTeamMember($teamMember);

                $validated = $request->validate([
                    'address_name' => 'nullable|string|max:255',
                    'address' => 'required|string',
                    'city' => 'nullable|string|max:255',
                    'state' => 'nullable|string|max:255',
                    'postal_code' => 'nullable|string|max:20',
                    'country' => 'required|string|max:255',
                    'is_primary' => 'boolean',
                ]);

                // If this address is being set as primary, remove primary status from other addresses
                if ($request->boolean('is_primary')) {
                    $teamMember->addresses()->update(['is_primary' => false]);
                }

                $address = $teamMember->addresses()->create($validated);

                return response()->json([
                    'success' => true,
                    'message' => 'Address added successfully.',
                    'data' => $address
                ]);

            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                \Log::error('Failed to add address: ' . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add address: ' . $e->getMessage()
                ], 500);
            }
        }
        public function removeAddress(TeamMember $teamMember, Address $address): JsonResponse
        {        
            try {
                $this->authorizeTeamMember($teamMember);

                if ($address->team_member_id === $teamMember->id) {
                    $address->delete();

                    return response()->json([
                        'success' => true,
                        'message' => 'Address removed successfully.'
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);

            } catch (\Exception $e) {
               // \Log::error('Failed to remove address: ' . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove address: ' . $e->getMessage()
                ], 500);
            }
        }


    public function addEmergencyContact(Request $request, TeamMember $teamMember): JsonResponse
    {
            try {
                $this->authorizeTeamMember($teamMember);
                $validated = $request->validate([
                    'full_name' => 'required|string|max:255',
                    'relationship' => 'required|string|max:255',
                    'email' => 'nullable|email',
                    'phone_number' => 'required|string|max:20',
                ]);
                $emergencyContact = $teamMember->emergencyContacts()->create($validated);

                return response()->json([
                    'success' => true,
                    'message' => 'Emergency contact added successfully.',
                    'data' => $emergencyContact
                ]);

            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add emergency contact: ' . $e->getMessage()
                ], 500);
            }
        }

        public function updateservices(Request $request, TeamMember $teamMember): JsonResponse
        {
            try {
                $this->authorizeTeamMember($teamMember);

                $request->validate([
                    'services' => 'sometimes|array',
                    'services.*' => 'exists:services,id'
                ]);

                if ($request->has('services')) {
                    $teamMember->services()->sync($request->services);
                } else {
                    $teamMember->services()->detach();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Services updated successfully',
                    'data' => $teamMember->services
                ]);

            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update services: ' . $e->getMessage()
                ], 500);
            }
        }
        public function removeEmergencyContact(TeamMember $teamMember, EmergencyContact $emergencyContact): JsonResponse
            {
                try {
                    $this->authorizeTeamMember($teamMember);

                    if ($emergencyContact->team_member_id === $teamMember->id) {
                        $emergencyContact->delete();

                        return response()->json([
                            'success' => true,
                            'message' => 'Emergency contact removed successfully.'
                        ]);
                    }

                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized action.'
                    ], 403);

                } catch (\Exception $e) {
                    \Log::error('Failed to remove emergency contact: ' . $e->getMessage());

                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to remove emergency contact: ' . $e->getMessage()
                    ], 500);
                }
            }
    private function authorizeTeamMember(TeamMember $teamMember)
    {
        $storeId = auth()->guard('store')->user()->id;
        if ($teamMember->store_id !== $storeId) {
            abort(403, 'Unauthorized action.');
        }
    }
}