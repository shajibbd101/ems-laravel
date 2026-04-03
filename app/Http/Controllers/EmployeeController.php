<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->search.'%');
            });
        }

        if ($request->designation) {
            $query->where('designation', $request->designation);
        }

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
            'joining_date' => 'nullable|date_format:d/m/Y',
        ]);

        $data = $request->all();

        if (! empty($data['joining_date'])) {
            $data['joining_date'] = $this->convertDate($data['joining_date']);
        }

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
            'joining_date' => 'nullable|date_format:d/m/Y',
        ]);

        $data = $request->all();

        if (! empty($data['joining_date'])) {
            $data['joining_date'] = $this->convertDate($data['joining_date']);
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    private function convertDate($date)
    {
        if (empty($date)) {
            return $date;
        }
        $parts = explode('/', $date);
        if (count($parts) === 3) {
            return $parts[2].'-'.$parts[1].'-'.$parts[0];
        }

        return $date;
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

        if ($request->filled('designation')) {
            $employees->where('designation', $request->designation);
        }

        $employees = $employees->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('employees.index', compact('employees'));
    }
    // end
}
