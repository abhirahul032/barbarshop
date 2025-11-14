<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Package;
class StoreController extends Controller
{
    /*
    public function index()
    {
        $stores = Store::with('package')->paginate(20);
        return view('admin.store.index', compact('stores'));
    }
    */

    public function index(Request $request)
    {
        $query = Store::with('package');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }
        
        // Sorting functionality
        $sortField = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort field to prevent SQL injection
        $allowedSorts = ['id', 'name', 'email', 'no_of_employees', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'id';
        }
        
        $query->orderBy($sortField, $sortDirection);
        
        $stores = $query->paginate(20);
        
        return view('admin.store.index', compact('stores', 'sortField', 'sortDirection'));
    }
    public function create()
    {
        $packages = Package::all();
        return view('admin.store.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'required|url',
            'email' => 'required|email|unique:stores,email',
            'password' => 'required|min:6',
            'no_of_employees' => 'required|integer|min:1',
            'package_id' => 'required|exists:packages,id'
        ], [
            'name.required' => 'The store name is required.',
            'name.max' => 'The store name may not be greater than 255 characters.',
            'logo.image' => 'The logo must be an image file.',
            'logo.mimes' => 'The logo must be a JPEG, PNG, JPG, or GIF file.',
            'logo.max' => 'The logo may not be greater than 2MB.',
            'url.required' => 'The URL is required.',
            'url.url' => 'Please enter a valid URL.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'no_of_employees.required' => 'The number of employees is required.',
            'no_of_employees.integer' => 'The number of employees must be a whole number.',
            'no_of_employees.min' => 'The number of employees must be at least 1.',
            'no_of_employees.max' => 'The number of employees may not be greater than 10000.',
            'package_id.required' => 'Please select a package.',
            'package_id.exists' => 'The selected package is invalid.'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos','public');
        }

        $data['password'] = bcrypt($data['password']);

        Store::create($data);

         return redirect()->route('admin.store.index')->with('success', 'Store created successfully');
    }

    public function show(Store $store)
    {
        return view('admin.store.view', compact('store'));
    }
    
    public function edit(Store $store)
    {
        $packages = Package::all();
        return view('admin.store.edit', compact('store', 'packages'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'required|url',
            'email' => 'required|email|unique:stores,email,' . $store->id,
            'no_of_employees' => 'required|integer|min:1',
            'package_id' => 'required|exists:packages,id'
        ],[
            'name.required' => 'The store name is required.',
            'name.max' => 'The store name may not be greater than 255 characters.',
            'logo.image' => 'The logo must be an image file.',
            'logo.mimes' => 'The logo must be a JPEG, PNG, JPG, or GIF file.',
            'logo.max' => 'The logo may not be greater than 2MB.',
            'url.required' => 'The URL is required.',
            'url.url' => 'Please enter a valid URL.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.min' => 'The password must be at least 6 characters.',
            'no_of_employees.required' => 'The number of employees is required.',
            'no_of_employees.integer' => 'The number of employees must be a whole number.',
            'no_of_employees.min' => 'The number of employees must be at least 1.',
            'no_of_employees.max' => 'The number of employees may not be greater than 10000.',
            'package_id.required' => 'Please select a package.',
            'package_id.exists' => 'The selected package is invalid.'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($store->logo && Storage::disk('public')->exists($store->logo)) {
                Storage::disk('public')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $store->update($data);

        return redirect()->route('admin.store.index')->with('success', 'Store updated successfully');
    }

    public function destroy(Store $store)
    {
        // Delete logo if exists
        if ($store->logo && Storage::disk('public')->exists($store->logo)) {
            Storage::disk('public')->delete($store->logo);
        }
        
        $store->delete();
        return back()->with('success', 'Store deleted successfully');
    }
}

