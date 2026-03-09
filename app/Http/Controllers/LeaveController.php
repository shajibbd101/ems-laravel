<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        // $leaves = Leave::with('employee')->get();

        $query = Leave::with('employee');

        if ($request->search) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        $leaves = $query->latest()
                           ->paginate(8)
                           ->withQueryString();

        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('leaves.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $days = \Carbon\Carbon::parse($request->from_date)
            ->diffInDays(\Carbon\Carbon::parse($request->to_date)) + 1;

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        Leave::create([
            'employee_id' => $request->employee_id,
            'type' => $request->type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'days' => $days,
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave added successfully!');
    }

    // Edit and Update methods would go here

    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        $employees = Employee::all();

        return view('leaves.edit', compact('leave', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);

        $days = \Carbon\Carbon::parse($request->from_date)
            ->diffInDays(\Carbon\Carbon::parse($request->to_date)) + 1;

        $leave->update([
            'employee_id' => $request->employee_id,
            'type' => $request->type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'days' => $days,
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully!');
    }

    // Destroy method would go here

    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully!');
    }

    // use name box fo search name (overtime & Leave)
    public function search(Request $request)
    {
        $query = $request->get('query');

        $employees = Employee::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name')
            ->limit(5)
            ->get();

        return response()->json($employees);
    }

     // search function
    public function name_search(Request $request)
    {

         $leaves = Leave::with('employee')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->whereHas('employee', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('id', 'desc')   // ✅ keep consistent order
            ->paginate(10)
            ->withQueryString();

        return view('leaves.index', compact('leaves'));
    }
    // end
}