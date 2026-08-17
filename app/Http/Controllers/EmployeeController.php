<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('department')->latest()->paginate(7);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('employees.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'job_title' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'تم إضافة الموظف بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return redirect()->route('employees.edit', $employee->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'job_title' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'تم تحديث بيانات الموظف بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'تم حذف الموظف بنجاح.');
    }
}
