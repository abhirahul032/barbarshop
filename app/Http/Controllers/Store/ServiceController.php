<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;


class ServiceController extends Controller
{
    public function index(Request $request)
    {
      
        $query = Service::where('store_id', auth()->user()->id);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $services = $query->paginate(10);

        return view('store.services.index', compact('services'));
    }

    public function create()
    {
        return view('store.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
        ]);

        $validated['store_id'] = auth()->user()->id;
        Service::create($validated);

        return redirect()->route('store.services.index')->with('success', 'Service created successfully.');
    }
    public function show(Service $service)
    {
        //$this->authorize('view', $service);

        // Load the employees relationship to avoid N+1 queries
        $service->load('employees');

        return view('store.services.show', compact('service'));
    }
    public function edit(Service $service)
    {
        //$this->authorize('update', $service);
        return view('store.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
       // $this->authorize('update', $service);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $service->update($validated);

        return redirect()->route('store.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
       // $this->authorize('delete', $service);
        $service->delete();
        
        return redirect()->route('store.services.index')->with('success', 'Service deleted successfully.');
    }
}