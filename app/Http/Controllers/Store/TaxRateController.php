<?php
// app/Http/Controllers/Store/TaxRateController.php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    public function index()
    {
        $store = auth()->guard('store')->user();
        $taxRates = TaxRate::withCount('memberships')
            ->where('store_id', $store->id)
            ->get();
        return view('store.tax-rates.index', compact('taxRates'));
    }

    public function store(Request $request)
    {
        $store = auth()->guard('store')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        TaxRate::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'rate' => $request->rate,
            'is_default' => $request->boolean('is_default')
        ]);

        return redirect()->back()->with('success', 'Tax rate created successfully.');
    }

    public function update(Request $request, TaxRate $taxRate)
    {
        $this->authorizeAccess($taxRate);

        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        $taxRate->update([
            'name' => $request->name,
            'rate' => $request->rate,
            'is_default' => $request->boolean('is_default')
        ]);

        return redirect()->back()->with('success', 'Tax rate updated successfully.');
    }

    public function destroy(TaxRate $taxRate)
    {
        $this->authorizeAccess($taxRate);

        if ($taxRate->memberships()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete tax rate that is being used by memberships.');
        }

        $taxRate->delete();

        return redirect()->back()->with('success', 'Tax rate deleted successfully.');
    }

    private function authorizeAccess(TaxRate $taxRate)
    {
        $store = auth()->guard('store')->user();
        if ($taxRate->store_id !== $store->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}