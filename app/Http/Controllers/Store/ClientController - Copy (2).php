<?php
// app/Http/Controllers/Store/ClientController.php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ClientEmergencyContact;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index(): View
    {
        $store = Auth::guard('store')->user();
        $clients = Client::with(['addresses', 'emergencyContacts'])
            ->where('store_id', $store->id)
            ->latest()
            ->paginate(10);

        return view('store.clients.index', compact('clients'));
    }

    public function create(): View
    {
        $store = Auth::guard('store')->user();
        $existingClients = Client::where('store_id', $store->id)->get();
        return view('store.clients.create', compact('existingClients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $store = Auth::guard('store')->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,NULL,id,store_id,' . $store->id,
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'birth_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'gender' => 'nullable|string|max:50',
            'pronouns' => 'nullable|string|max:50',
            'client_source' => 'nullable|string|max:255',
            'referred_by_client_id' => 'nullable|exists:clients,id',
            'preferred_language' => 'nullable|string|max:10',
            'occupation' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'additional_email' => 'nullable|email',
            'additional_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            
            // Notification settings
            'email_notifications' => 'boolean',
            'text_message_notifications' => 'boolean',
            'whatsapp_notifications' => 'boolean',
            'email_marketing' => 'boolean',
            'text_message_marketing' => 'boolean',
            'whatsapp_marketing' => 'boolean',
        ]);

        $validated['store_id'] = $store->id;

        $client = Client::create($validated);

        return redirect()->route('store.clients.show', $client)
            ->with('success', 'Client created successfully.');
    }

    public function show(Client $client): View
    {
        $this->authorizeAccess($client);
        $client->load(['addresses', 'emergencyContacts', 'memberships', 'referredBy']);
        return view('store.clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        $this->authorizeAccess($client);
        $store = Auth::guard('store')->user();
        $existingClients = Client::where('store_id', $store->id)
            ->where('id', '!=', $client->id)
            ->get();
        $client->load(['addresses', 'emergencyContacts']);
        return view('store.clients.edit', compact('client', 'existingClients'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $this->authorizeAccess($client);
        $store = Auth::guard('store')->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id . ',id,store_id,' . $store->id,
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'birth_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'gender' => 'nullable|string|max:50',
            'pronouns' => 'nullable|string|max:50',
            'client_source' => 'nullable|string|max:255',
            'referred_by_client_id' => 'nullable|exists:clients,id',
            'preferred_language' => 'nullable|string|max:10',
            'occupation' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'additional_email' => 'nullable|email',
            'additional_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            
            // Notification settings
            'email_notifications' => 'boolean',
            'text_message_notifications' => 'boolean',
            'whatsapp_notifications' => 'boolean',
            'email_marketing' => 'boolean',
            'text_message_marketing' => 'boolean',
            'whatsapp_marketing' => 'boolean',
        ]);

        $client->update($validated);

        return redirect()->route('store.clients.show', $client)
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->authorizeAccess($client);
        $client->delete();

        return redirect()->route('store.clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    // Address Management Methods
    public function storeAddress(Request $request, Client $client): RedirectResponse
    {
        $this->authorizeAccess($client);

        $validated = $request->validate([
            'type' => 'required|in:home,work,other',
            'address_name' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'apt_suite' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'region' => 'required|string|max:100',
            'postcode' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_primary' => 'boolean',
        ]);

        $client->addresses()->create($validated);

        return back()->with('success', 'Address added successfully.');
    }

    // Emergency Contact Management Methods
    public function storeEmergencyContact(Request $request, Client $client): RedirectResponse
    {
        $this->authorizeAccess($client);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'relationship' => 'required|string|max:100',
            'is_primary' => 'boolean',
        ]);

        $client->emergencyContacts()->create($validated);

        return back()->with('success', 'Emergency contact added successfully.');
    }

    public function destroyAddress(Client $client, ClientAddress $address): RedirectResponse
    {
        $this->authorizeAccess($client);
        $address->delete();
        return back()->with('success', 'Address deleted successfully.');
    }

    public function destroyEmergencyContact(Client $client, ClientEmergencyContact $emergencyContact): RedirectResponse
    {
        $this->authorizeAccess($client);
        $emergencyContact->delete();
        return back()->with('success', 'Emergency contact deleted successfully.');
    }

    private function authorizeAccess(Client $client)
    {
        $store = Auth::guard('store')->user();
        if ($client->store_id !== $store->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}