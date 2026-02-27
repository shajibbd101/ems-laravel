<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::with('employee')->get();
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

        Leave::create([
            'employee_id' => $request->employee_id,
            'type' => $request->type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'days' => $days,
        ]);

        return redirect()->route('leaves.index');
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

        return redirect()->route('leaves.index');
    }

    // Destroy method would go here

    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();

        return redirect()->route('leaves.index');
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
        $search = $request->search;

        $leaves = Leave::with('employee')
            ->whereHas('employee', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        return view('leaves.index', compact('leaves'));
    }
    // end
}