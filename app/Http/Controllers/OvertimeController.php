<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Overtime;
use App\Models\Employee;

class OvertimeController extends Controller
{   

    public function index()
    {
        $overtimes = Overtime::with('employee')->get();
        return view('overtimes.index', compact('overtimes'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('overtimes.create', compact('employees'));
    }

    public function store(Request $request)
    {
        Overtime::create($request->all());
        return redirect()->route('overtimes.index');
    }

    // Edit 

    public function edit(Overtime $overtime)
    {
        $overtime = Overtime::findOrFail($overtime->id);
        $employees = Employee::all();
        return view('overtimes.edit', compact('overtime', 'employees'));
    }

    // Update

    public function update(Request $request, $id)
    {
        $overtime = Overtime::findOrFail($id);

        $overtime->update([
            'employee_id' => $request->employee_id,
            'type' => $request->type,
            'date' => $request->date,
        ]);

        return redirect()->route('overtimes.index')->with('success', 'Updated!');
    }

    // Delete

    public function destroy($id)
    {
        $overtime = Overtime::findOrFail($id);
        $overtime->delete();

        return redirect()->route('overtimes.index')->with('success', 'Deleted!');
    }

    // search function
    public function name_search(Request $request)
    {
        $search = $request->search;

        $overtimes = Overtime::with('employee')
            ->whereHas('employee', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        return view('overtimes.index', compact('overtimes'));
    }
    // end
}