<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalService;
use App\Models\BusinessType;

class GlobalServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = GlobalService::with('businessType');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhereHas('businessType', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by business type
        if ($request->has('business_type_id') && !empty($request->business_type_id)) {
            $query->where('business_type_id', $request->business_type_id);
        }
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // Filter by type
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }
        
        // Filter by status
        if (!is_null($request->status) && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        
        // Sorting functionality
        $sortField = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort field to prevent SQL injection
        $allowedSorts = ['id', 'name', 'category', 'type', 'price', 'is_active', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'id';
        }
        
        $query->orderBy($sortField, $sortDirection);
        
        $globalServices = $query->paginate(20);
        $businessTypes = BusinessType::where('is_active', true)->get();
        $categories = GlobalService::distinct()->pluck('category');
        
        return view('admin.global-service.index', compact(
            'globalServices', 
            'businessTypes',
            'categories',
            'sortField', 
            'sortDirection'
        ));
    }

    public function create()
    {
        $businessTypes = BusinessType::where('is_active', true)->get();
        return view('admin.global-service.create', compact('businessTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_type_id' => 'required|exists:business_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,hourly',
            'price' => 'required_if:type,fixed|numeric|min:0',
            'hourly_price' => 'required_if:type,hourly|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
            'is_active' => 'boolean'
        ], [
            'business_type_id.required' => 'Please select a business type.',
            'name.required' => 'The service name is required.',
            'price.required_if' => 'Price is required for fixed type services.',
            'hourly_price.required_if' => 'Hourly price is required for hourly type services.',
            'duration_minutes.required' => 'Duration is required.',
            'category.required' => 'Category is required.',
        ]);

        GlobalService::create([
            'business_type_id' => $request->business_type_id,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'price' => $request->price ?? 0,
            'hourly_price' => $request->hourly_price ?? 0,
            'duration_minutes' => $request->duration_minutes,
            'category' => $request->category,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.global-service.index')->with('success', 'Global service created successfully.');
    }

    public function show(GlobalService $globalService)
    {
        $globalService->load('businessType');
        return view('admin.global-service.view', compact('globalService'));
    }

    public function edit(GlobalService $globalService)
    {
        $businessTypes = BusinessType::where('is_active', true)->get();
        
        return view('admin.global-service.edit', compact('globalService', 'businessTypes'));
    }

    public function update(Request $request, GlobalService $globalService)
    {
        $request->validate([
            'business_type_id' => 'required|exists:business_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,hourly',
            'price' => 'required_if:type,fixed|numeric|min:0',
            'hourly_price' => 'required_if:type,hourly|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
            'is_active' => 'boolean'
        ], [
            'business_type_id.required' => 'Please select a business type.',
            'name.required' => 'The service name is required.',
            'price.required_if' => 'Price is required for fixed type services.',
            'hourly_price.required_if' => 'Hourly price is required for hourly type services.',
            'duration_minutes.required' => 'Duration is required.',
            'category.required' => 'Category is required.',
        ]);

        $globalService->update([
            'business_type_id' => $request->business_type_id,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'price' => $request->price ?? 0,
            'hourly_price' => $request->hourly_price ?? 0,
            'duration_minutes' => $request->duration_minutes,
            'category' => $request->category,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.global-service.index')->with('success', 'Global service updated successfully.');
    }

    public function destroy(GlobalService $globalService)
    {
        $globalService->delete();
        return back()->with('success', 'Global service deleted successfully.');
    }
}