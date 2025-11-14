<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    /*
   public function index()
    {
        $packages = Package::paginate(20);
        return view('admin.package.index', compact('packages'));
    }
    */

    public function index(Request $request)
    {
        $query = Package::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        
        // Sorting functionality
        $sortField = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort field to prevent SQL injection
        $allowedSorts = ['id', 'name', 'price', 'duration', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'id';
        }
        
        $query->orderBy($sortField, $sortDirection);
        
        $packages = $query->paginate(20);
        
        // Keep search and sort parameters in pagination links
        $packages->appends([
            'search' => $request->search,
            'sort' => $sortField,
            'direction' => $sortDirection
        ]);
        
        return view('admin.package.index', compact('packages', 'sortField', 'sortDirection'));
    }
    public function create()
    {
        return view('admin.package.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'duration'=>'required|numeric'
        ]);

         Package::create($request->all());
        return redirect()->route('admin.package.index')->with('success', 'Package created successfully');
    }

    public function edit(Package $package)
    {
        return view('admin.package.edit', compact('package'));
    }

    public function show(Package $package)
    {
        return view('admin.package.view', compact('package'));
    }
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'duration'=>'required|numeric'
        ]);

        $package->update($request->all());
        return redirect()->route('admin.package.index')->with('success', 'Package updated successfully');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return back()->with('success', 'Package deleted successfully');
    }
}
