<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessType;

class BusinessTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = BusinessType::query();        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if(!is_null($request->status)){
            if (($request->has('status') && $request->status !== '' ) ||  ($request->has('status') && $request->status === 0  ) ) {               
                $query->where('is_active', $request->status);
            }
        }
        
        // Sorting functionality
        $sortField = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort field to prevent SQL injection
        $allowedSorts = ['id', 'name', 'is_active', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'id';
        }
        
        $query->orderBy($sortField, $sortDirection);
        
        $businessTypes = $query->paginate(20);
        
        return view('admin.business-type.index', compact('businessTypes', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        return view('admin.business-type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:business_types,name',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'The business type name is required.',
            'name.max' => 'The business type name may not be greater than 255 characters.',
            'name.unique' => 'This business type name already exists.',
            'description.max' => 'The description may not be greater than 500 characters.',
        ]);

        BusinessType::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.business-type.index')->with('success', 'Business type created successfully.');
    }

    public function show(BusinessType $businessType)
    {
         // Load global services for this business type with pagination
        $globalServices = $businessType->globalServices()->orderBy('created_at', 'desc')->paginate(10);
       
        return view('admin.business-type.view', compact('businessType', 'globalServices'));
        #return view('admin.business-type.view', compact('businessType'));
    }

    public function edit(BusinessType $businessType)
    {
        return view('admin.business-type.edit', compact('businessType'));
    }

    public function update(Request $request, BusinessType $businessType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:business_types,name,' . $businessType->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'The business type name is required.',
            'name.max' => 'The business type name may not be greater than 255 characters.',
            'name.unique' => 'This business type name already exists.',
            'description.max' => 'The description may not be greater than 500 characters.',
        ]);

        $businessType->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.business-type.index')->with('success', 'Business type updated successfully.');
    }

    public function destroy(BusinessType $businessType)
    {
        $businessType->delete();
        return back()->with('success', 'Business type deleted successfully.');
    }
}