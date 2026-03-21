<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->search.'%');
            });
        }

        // 📄 Pagination
        $employees = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email|unique:employees',
            'phone' => 'required|numeric|unique:employees',
            'designation' => 'required',
            'salary' => 'nullable|numeric',
            'joining_date' => 'nullable|date',
            // 'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ✅ Get all data
        $data = $request->all();

        // ✅ Save to database
        Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email|unique:employees,email,'.$employee->id,
            'phone' => 'required|numeric|unique:employees,phone,'.$employee->id,
            'designation' => 'required',
            'salary' => 'nullable|numeric',
            'joining_date' => 'nullable|date',
            // 'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }

    // search function
    public function name_search(Request $request)
    {
        $employees = Employee::query();

        if ($request->filled('search')) {
            $employees->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('phone', 'like', '%'.$request->search.'%');
            });
        }

        $employees = $employees->orderBy('id', 'desc') // keep consistent order
            ->paginate(15)
            ->withQueryString();

        return view('employees.index', compact('employees'));
    }
    // end
}
