<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Overtime;
use App\Models\Employee;
use Carbon\Carbon;

class OvertimeController extends Controller
{   

    public function index(Request $request)
    {

        $query = Overtime::with('employee');

        // Name Search
        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->search) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Month filter
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);

            $query->whereYear('date', $month->year)
                  ->whereMonth('date', $month->month);
        }

        $overtimes = $query->latest()
                            ->paginate(8)
                            ->withQueryString();

        // Monthly Total Count Per Employee

        $monthlyTotals = Overtime::selectRaw("
                employee_id,
                SUM(CASE WHEN type = 'OnDay' THEN 1 ELSE 0 END) as total_on,
                SUM(CASE WHEN type = 'OffDay' THEN 1 ELSE 0 END) as total_off
            ")
            ->when($request->filled('month'), function ($q) use ($request) {
                $month = Carbon::parse($request->month);
                $q->whereYear('date', $month->year)
                ->whereMonth('date', $month->month);
            })
            ->groupBy('employee_id')
            ->get()
            ->keyBy('employee_id');

        return view('overtimes.index', compact('overtimes', 'monthlyTotals'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('overtimes.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required',
            'date' => 'required|date',
        ]);

        Overtime::create([
            'employee_id' => $request->employee_id,
            'type' => $request->type,
            'date' => $request->date,
        ]);

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

    //overtime summary

    public function summary(Request $request)
    {
        // $month = $request->filled('month')
        //     ? Carbon::parse($request->month)
        //     : now();

        // $summary = Overtime::selectRaw("
        //         employee_id,
        //         SUM(CASE WHEN type = 'OnDay' THEN 1 ELSE 0 END) as total_on,
        //         SUM(CASE WHEN type = 'OffDay' THEN 1 ELSE 0 END) as total_off
        //     ")
        //     ->whereYear('date', $month->year)
        //     ->whereMonth('date', $month->month)
        //     ->groupBy('employee_id')
        //     ->with('employee')
        //     ->get();

        // return view('overtimes.summary', compact('summary', 'month'));

        $month = $request->filled('month')
                ? Carbon::parse($request->month)
                : now();

            $query = Overtime::selectRaw("
                    employee_id,
                    SUM(CASE WHEN type = 'OnDay' THEN 1 ELSE 0 END) as total_on,
                    SUM(CASE WHEN type = 'OffDay' THEN 1 ELSE 0 END) as total_off
                ")
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->groupBy('employee_id')
                ->with('employee');

            // 🔍 Search by employee name
            if ($request->filled('search')) {
                $query->whereHas('employee', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            }

            $summary = $query->paginate(5)->withQueryString();

            return view('overtimes.summary', compact('summary', 'month'));
    }
}