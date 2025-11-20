<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller; // Add this import
use App\Models\TeamMember;
use App\Models\Store;
use App\Models\Service;
use App\Models\Address;
use App\Models\EmergencyContact;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller // Now this will work
{
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
        $Country=Country::all();
        echo '<pre>';print_r($Country);echo '</pre>';exit;
        
        return view('store.team-members.create', compact('services', 'locations','Country'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:team_members,email',
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
            'calendar_color' => 'nullable|string|max:7',
            'services' => 'array',
            'services.*' => 'exists:services,id',
            'locations' => 'array',
            'locations.*' => 'exists:stores,id',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $storeId = auth()->guard('store')->user()->id;
            
            $teamMember = TeamMember::create(array_merge($validated, [
                'store_id' => $storeId,
                'visible_to_clients' => $request->has('visible_to_clients'),
            ]));

            // Sync services
            if ($request->has('services')) {
                $teamMember->services()->sync($request->services);
            }

            // Sync locations
            if ($request->has('locations')) {
                $teamMember->locations()->sync($request->locations);
            }
        });

        return redirect()->route('store.team-members.index')->with('success', 'Team member created successfully.');
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
        
        $teamMember->load(['addresses', 'emergencyContacts', 'services', 'locations']);
        
        return view('store.team-members.edit', compact('teamMember', 'services', 'locations'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        // Check if team member belongs to the authenticated store
        $this->authorizeTeamMember($teamMember);
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:team_members,email,' . $teamMember->id,
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
            'calendar_color' => 'nullable|string|max:7',
            'services' => 'array',
            'services.*' => 'exists:services,id',
            'locations' => 'array',
            'locations.*' => 'exists:stores,id',
        ]);

        DB::transaction(function () use ($validated, $request, $teamMember) {
            $teamMember->update(array_merge($validated, [
                'visible_to_clients' => $request->has('visible_to_clients'),
            ]));

            // Sync services
            if ($request->has('services')) {
                $teamMember->services()->sync($request->services);
            } else {
                $teamMember->services()->detach();
            }

            // Sync locations
            if ($request->has('locations')) {
                $teamMember->locations()->sync($request->locations);
            } else {
                $teamMember->locations()->detach();
            }
        });

        return redirect()->route('store.team-members.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $teamMember)
    {
        // Check if team member belongs to the authenticated store
        $this->authorizeTeamMember($teamMember);
        
        $teamMember->delete();
        return redirect()->route('store.team-members.index')->with('success', 'Team member deleted successfully.');
    }

    public function addAddress(Request $request, TeamMember $teamMember)
    {
        // Check if team member belongs to the authenticated store
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

        $teamMember->addresses()->create($validated);

        return back()->with('success', 'Address added successfully.');
    }

    public function addEmergencyContact(Request $request, TeamMember $teamMember)
    {
        // Check if team member belongs to the authenticated store
        $this->authorizeTeamMember($teamMember);
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone_number' => 'required|string|max:20',
        ]);

        $teamMember->emergencyContacts()->create($validated);

        return back()->with('success', 'Emergency contact added successfully.');
    }

    public function removeAddress(TeamMember $teamMember, Address $address)
    {
        // Check if team member belongs to the authenticated store
        $this->authorizeTeamMember($teamMember);
        
        if ($address->team_member_id === $teamMember->id) {
            $address->delete();
            return back()->with('success', 'Address removed successfully.');
        }

        return back()->with('error', 'Unauthorized action.');
    }

    public function removeEmergencyContact(TeamMember $teamMember, EmergencyContact $emergencyContact)
    {
        // Check if team member belongs to the authenticated store
        $this->authorizeTeamMember($teamMember);
        
        if ($emergencyContact->team_member_id === $teamMember->id) {
            $emergencyContact->delete();
            return back()->with('success', 'Emergency contact removed successfully.');
        }

        return back()->with('error', 'Unauthorized action.');
    }

    /**
     * Check if team member belongs to the authenticated store
     */
    private function authorizeTeamMember(TeamMember $teamMember)
    {
        $storeId = auth()->guard('store')->user()->id;
        if ($teamMember->store_id !== $storeId) {
            abort(403, 'Unauthorized action.');
        }
    }
}