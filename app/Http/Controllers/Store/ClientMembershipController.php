<?php
// app/Http/Controllers/Store/ClientMembershipController.php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientMembership;
use App\Models\Membership;
use App\Models\MembershipRedemption;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ClientMembershipController extends Controller
{
    public function index(Client $client): View
    {
        $this->authorizeAccess($client);
        
        $client->load(['memberships.membership', 'memberships.redemptions.service']);
        $memberships = Membership::where('store_id', Auth::guard('store')->user()->id)
            ->where('is_active', true)
            ->get();

        return view('store.clients.memberships.index', compact('client', 'memberships'));
    }

    public function store(Request $request, Client $client): RedirectResponse
    {
        $this->authorizeAccess($client);
        
        $validated = $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
            'sessions_used' => 'nullable|integer|min:0',
        ]);

        $membership = Membership::findOrFail($validated['membership_id']);
        
        // Calculate end date based on membership validity
        $endDate = $this->calculateEndDate($validated['start_date'], $membership);
        
        // Calculate sessions remaining
        $sessionsUsed = $validated['sessions_used'] ?? 0;
        $sessionsRemaining = $membership->session_type === 'limited' 
            ? max(0, $membership->session_count - $sessionsUsed)
            : 0;

        $clientMembership = ClientMembership::create([
            'client_id' => $client->id,
            'membership_id' => $membership->id,
            'start_date' => $validated['start_date'],
            'end_date' => $endDate,
            'sessions_used' => $sessionsUsed,
            'sessions_remaining' => $sessionsRemaining,
            'status' => 'active',
        ]);

      //  return redirect()->route('store.clients.memberships.index', $client)
       //     ->with('success', 'Membership added successfully.');
        return redirect()->route('store.clients.show', $client)
            ->with('success', 'Membership added successfully.');
    }

    public function update(Request $request, Client $client, ClientMembership $clientMembership): RedirectResponse
    {
        $this->authorizeAccess($client);
        
        $validated = $request->validate([
            'sessions_used' => 'required|integer|min:0',
            'status' => 'required|in:active,expired,cancelled',
        ]);

        $membership = $clientMembership->membership;
        $sessionsRemaining = $membership->session_type === 'limited' 
            ? max(0, $membership->session_count - $validated['sessions_used'])
            : 0;

        $clientMembership->update([
            'sessions_used' => $validated['sessions_used'],
            'sessions_remaining' => $sessionsRemaining,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Membership updated successfully.');
    }

    public function destroy(Client $client, ClientMembership $clientMembership): RedirectResponse
    {
        $this->authorizeAccess($client);
        
        $clientMembership->delete();

        return back()->with('success', 'Membership removed successfully.');
    }

    public function redeem(Request $request, Client $client, ClientMembership $clientMembership): RedirectResponse
    {
        $this->authorizeAccess($client);
        
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        if (!$clientMembership->canRedeemSession()) {
            return back()->with('error', 'Cannot redeem session. Membership may be expired or has no sessions remaining.');
        }

        // Redeem the session
        $redemption = MembershipRedemption::create([
            'client_membership_id' => $clientMembership->id,
            'service_id' => $validated['service_id'],
            'appointment_id' => $validated['appointment_id'] ?? null,
            'redeemed_at' => now(),
        ]);

        // Update membership usage
        $clientMembership->redeemSession();

        return back()->with('success', 'Session redeemed successfully.');
    }

    private function calculateEndDate(string $startDate, Membership $membership): string
    {
        $start = \Carbon\Carbon::parse($startDate);
        
        return match($membership->validity_period) {
            'days' => $start->addDays($membership->validity_duration)->toDateString(),
            'weeks' => $start->addWeeks($membership->validity_duration)->toDateString(),
            'months' => $start->addMonths($membership->validity_duration)->toDateString(),
            'years' => $start->addYears($membership->validity_duration)->toDateString(),
            default => $start->addMonth()->toDateString(),
        };
    }

    private function authorizeAccess(Client $client)
    {
        $store = Auth::guard('store')->user();
        if ($client->store_id !== $store->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}