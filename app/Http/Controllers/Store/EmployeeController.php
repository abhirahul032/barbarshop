<?php


namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Service;

use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
       
        
        $query = Employee::where('store_id', auth()->guard('store')->user()->id);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $employees = $query->paginate(10);

        return view('store.employees.index', compact('employees'));
    }

    public function create()
    {
        $services = Service::where('store_id', auth()->guard('store')->user()->id)->get();
        return view('store.employees.create', compact('services'));
    }

    public function store(Request $request)
    {
        //echo '<pre>'; print_r($request->all()); echo '</pre>'; exit;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'hire_date' => 'required|date',
            'employment_type' => 'required|in:full_time,part_time,contract',
            'working_days' => 'required|array',
            'start_time' => 'required',
            'end_time' => 'required',
            'salary_per_hour' => 'required|numeric|min:0',
            'specialization' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'bank_account_details' => 'nullable|string',
            'services' => 'nullable|array',
            'expertise_levels' => 'nullable|array',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employee-photos', 'public');
        }

        $validated['store_id'] = auth()->guard('store')->user()->id;
        $validated['working_days'] = $validated['working_days'];

        $employee = Employee::create($validated);

        // Attach services with expertise levels
        if ($request->has('services')) {
            $servicesData = [];
            foreach ($request->services as $index => $serviceId) {
                $servicesData[$serviceId] = [
                    'expertise_level' => $request->expertise_levels[$index] ?? 1
                ];
            }
            $employee->services()->attach($servicesData);
        }

        return redirect()->route('store.employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        //$this->authorize('view', $employee);
        return view('store.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        //$this->authorize('update', $employee);
        $services = Service::where('store_id', auth()->guard('store')->user()->id)->get();
        return view('store.employees.edit', compact('employee', 'services'));
    }

    public function update(Request $request, Employee $employee)
    {
        //$this->authorize('update', $employee);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'employment_type' => 'required|in:full_time,part_time,contract',
            'working_days' => 'required|array',
            'start_time' => 'required',
            'end_time' => 'required',
            'salary_per_hour' => 'required|numeric|min:0',
            'specialization' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'bank_account_details' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
            'services' => 'nullable|array',
            'expertise_levels' => 'nullable|array',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employee-photos', 'public');
        }

        $employee->update($validated);

        if ($request->has('services')) {
            $servicesData = [];
            foreach ($request->services as $index => $serviceId) {
                $servicesData[$serviceId] = [
                    'expertise_level' => $request->expertise_levels[$index] ?? 1
                ];
            }
            $employee->services()->sync($servicesData);
        } else {
            $employee->services()->detach();
        }
        
        return redirect()->route('store.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        //$this->authorize('delete', $employee);
        
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        
        $employee->delete();
        
        return redirect()->route('store.employees.index')->with('success', 'Employee deleted successfully.');
    }
}