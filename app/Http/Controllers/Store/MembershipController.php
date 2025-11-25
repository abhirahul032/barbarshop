<?php
// app/Http/Controllers/Store/MembershipController.php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Service;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    public function index()
    {
        $store = auth()->guard('store')->user();
        $memberships = Membership::with(['services', 'taxRate'])
            ->withCount('clientMemberships')
            ->where('store_id', $store->id)
            ->latest()
            ->get();

        return view('store.memberships.index', compact('memberships'));
    }

    public function create()
    {
        $store = auth()->guard('store')->user();
        $services = Service::where('store_id', $store->id)
            ->where('is_active', true)
            ->get();
        $taxRates = TaxRate::where('store_id', $store->id)->get();
        $categories = Service::where('store_id', $store->id)
            ->where('is_active', true)
            ->distinct()
            ->pluck('category');

        return view('store.memberships.create', compact('services', 'taxRates', 'categories'));
    }

    public function store(Request $request)
    {
        $store = auth()->guard('store')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:360',
            'color' => 'required|string',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'session_type' => 'required|in:limited,unlimited',
            'session_count' => 'required_if:session_type,limited|integer|min:1',
            'validity_period' => 'required|in:days,weeks,months,years',
            'validity_duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'tax_rate_id' => 'nullable|exists:tax_rates,id',
            'online_sales_enabled' => 'boolean',
            'online_redemption_enabled' => 'boolean',
            'terms_conditions' => 'nullable|string|max:3000'
        ]);

        try {
            DB::beginTransaction();

            $membership = Membership::create([
                'store_id' => $store->id,
                'name' => $request->name,
                'description' => $request->description,
                'color' => $request->color,
                'session_type' => $request->session_type,
                'session_count' => $request->session_count,
                'validity_period' => $request->validity_period,
                'validity_duration' => $request->validity_duration,
                'price' => $request->price,
                'tax_rate_id' => $request->tax_rate_id,
                'online_sales_enabled' => $request->boolean('online_sales_enabled'),
                'online_redemption_enabled' => $request->boolean('online_redemption_enabled'),
                'terms_conditions' => $request->terms_conditions,
            ]);

            $membership->services()->sync($request->services);

            DB::commit();

            return redirect()->route('store.memberships.index')
                ->with('success', 'Membership created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create membership: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Membership $membership)
    {
        $this->authorizeAccess($membership);
        
        $membership->load(['services', 'taxRate', 'clientMemberships.client']);
        
        return view('store.memberships.show', compact('membership'));
    }

    public function edit(Membership $membership)
    {
        $this->authorizeAccess($membership);
        
        $store = auth()->guard('store')->user();
        $services = Service::where('store_id', $store->id)
            ->where('is_active', true)
            ->get();
        $taxRates = TaxRate::where('store_id', $store->id)->get();
        $categories = Service::where('store_id', $store->id)
            ->where('is_active', true)
            ->distinct()
            ->pluck('category');

        $selectedServices = $membership->services->pluck('id')->toArray();

        return view('store.memberships.edit', compact('membership', 'services', 'taxRates', 'categories', 'selectedServices'));
    }

    public function update(Request $request, Membership $membership)
    {
        $this->authorizeAccess($membership);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:360',
            'color' => 'required|string',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'session_type' => 'required|in:limited,unlimited',
            'session_count' => 'required_if:session_type,limited|integer|min:1',
            'validity_period' => 'required|in:days,weeks,months,years',
            'validity_duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'tax_rate_id' => 'nullable|exists:tax_rates,id',
            'online_sales_enabled' => 'boolean',
            'online_redemption_enabled' => 'boolean',
            'terms_conditions' => 'nullable|string|max:3000'
        ]);

        try {
            DB::beginTransaction();

            $membership->update([
                'name' => $request->name,
                'description' => $request->description,
                'color' => $request->color,
                'session_type' => $request->session_type,
                'session_count' => $request->session_count,
                'validity_period' => $request->validity_period,
                'validity_duration' => $request->validity_duration,
                'price' => $request->price,
                'tax_rate_id' => $request->tax_rate_id,
                'online_sales_enabled' => $request->boolean('online_sales_enabled'),
                'online_redemption_enabled' => $request->boolean('online_redemption_enabled'),
                'terms_conditions' => $request->terms_conditions,
            ]);

            $membership->services()->sync($request->services);

            DB::commit();

            return redirect()->route('store.memberships.index')
                ->with('success', 'Membership updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update membership: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Membership $membership)
    {
        $this->authorizeAccess($membership);

        try {
            $membership->delete();
            return redirect()->route('store.memberships.index')
                ->with('success', 'Membership deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete membership: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Membership $membership)
    {
        $this->authorizeAccess($membership);

        $membership->update([
            'is_active' => !$membership->is_active
        ]);

        $status = $membership->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Membership {$status} successfully.");
    }

    public function getServicesByCategory(Request $request)
    {
        $store = auth()->guard('store')->user();
        
        $services = Service::where('store_id', $store->id)
            ->where('is_active', true);

        if ($request->has('category') && $request->category !== 'all') {
            $services->where('category', $request->category);
        }

        if ($request->has('search')) {
            $services->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json($services->get());
    }

    private function authorizeAccess(Membership $membership)
    {
        $store = auth()->guard('store')->user();
        if ($membership->store_id !== $store->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}