<?php
// app/Http/Controllers/Store/SupplierController.php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::guard('store')->user();
        $query = Supplier::where('store_id', $store->id);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('supplier_name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->latest()->paginate(10);

        return view('store.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('store.suppliers.create');
    }

    public function store(Request $request)
    {
        $store = Auth::guard('store')->user();

        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_description' => 'nullable|string',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'street' => 'nullable|string|max:500',
            'suburb' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'same_as_postal' => 'boolean',
        ]);

        $validated['store_id'] = $store->id;

        Supplier::create($validated);

        return redirect()->route('store.suppliers.index')
            ->with('success', 'Supplier added successfully.');
    }

    public function show(Supplier $supplier)
    {
        $this->authorizeAccess($supplier);
        return view('store.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $this->authorizeAccess($supplier);
        return view('store.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $this->authorizeAccess($supplier);

        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_description' => 'nullable|string',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'street' => 'nullable|string|max:500',
            'suburb' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'same_as_postal' => 'boolean',
        ]);

        $supplier->update($validated);

        return redirect()->route('store.suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $this->authorizeAccess($supplier);
        $supplier->delete();

        return redirect()->route('store.suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }

    private function authorizeAccess(Supplier $supplier)
    {
        $store = Auth::guard('store')->user();
        if ($supplier->store_id !== $store->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}