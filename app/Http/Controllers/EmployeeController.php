<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        // 🔍 Search
        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%');
        }

        // 📄 Pagination
        $employees = $query->paginate(5);

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
            'email' => 'required|email|unique:employees',
            'phone' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'department' => 'required',
            'salary' => 'required|numeric',
            'joining_date' => 'required|date'
        ]);

        // ✅ Get all data
        $data = $request->all();

        // ✅ Handle file upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // ✅ Save to database
        Employee::create($data);

        // Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee added!');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:employees,email,' . $employee->id,
                'phone' => 'required',
                'department' => 'required',
                'salary' => 'required|numeric',
                'joining_date' => 'required|date',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $data = $request->all();

            // ✅ Delete old photo
            if ($request->hasFile('photo')) {

                if ($employee->photo && file_exists(storage_path('app/public/' . $employee->photo))) {
                    unlink(storage_path('app/public/' . $employee->photo));
                }

                // ✅ Upload new photo
                $data['photo'] = $request->file('photo')->store('photos', 'public');
            }

            $employee->update($data);

            return redirect()->route('employees.index')->with('success', 'Employee updated!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }
}