<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Overtime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Overtime::with('employee');

        // Name or Employee Number Search
        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('employee_number', 'LIKE', '%'.$request->search.'%');
            });
        }

        // Specific date filter
        if ($request->filled('date')) {
            $query->whereDate('date', Carbon::parse($request->date)->format('Y-m-d'));
        }

        // Month filter
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);

            $query->whereYear('date', $month->year)
                ->whereMonth('date', $month->month);
        }

        $overtimes = $query->latest()
            ->paginate(15)
            ->withQueryString();

        // Monthly Total Count Per Employee
        $monthFilter = $request->filled('month') ? Carbon::parse($request->month) : now();

        $monthlyTotals = Overtime::selectRaw("
                employee_id,
                SUM(CASE WHEN type = 'OnDay' THEN 1 ELSE 0 END) as total_on,
                SUM(CASE WHEN type = 'OffDay' THEN 1 ELSE 0 END) as total_off
            ")
            ->whereYear('date', $monthFilter->year)
            ->whereMonth('date', $monthFilter->month)
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
        $request->merge([
            'date' => $this->convertDate($request->date),
        ]);

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required',
            'shift' => 'nullable|in:A,B,C',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $existingCount = Overtime::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->count();

        if ($existingCount >= 2) {
            $employee = Employee::find($request->employee_id);

            return redirect()->back()
                ->withInput()
                ->with('employee_name', $employee->name ?? '')
                ->with('error', 'Maximum 2 overtime entries allowed per employee per date!');
        }

        Overtime::create([
            'employee_id' => $request->employee_id,
            'type' => $request->type,
            'shift' => $request->shift,
            'date' => $request->date,
        ]);

        return redirect()->route('overtimes.index')->with('success', 'Overtime added successfully!');
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

        $request->merge([
            'date' => $this->convertDate($request->date),
        ]);

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required',
            'shift' => 'nullable|in:A,B,C',
            'date' => 'required|date_format:Y-m-d',
        ]);

        // Check for max 2 entries excluding current record
        $existingCount = Overtime::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->where('id', '!=', $id)
            ->count();

        if ($existingCount >= 2) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Maximum 2 overtime entries allowed per employee per date!');
        }

        $overtime->update([
            'employee_id' => $request->employee_id,
            'type' => $request->type,
            'shift' => $request->shift,
            'date' => $request->date,
        ]);

        return redirect()->route('overtimes.index')->with('success', 'Overtime updated successfully!');
    }

    // Delete

    public function destroy($id)
    {
        $overtime = Overtime::findOrFail($id);
        $overtime->delete();

        return redirect()->route('overtimes.index')->with('success', 'Overtime deleted successfully!');
    }

    // overtime summary

    public function summary(Request $request)
    {
        $month = $request->filled('month')
                ? Carbon::parse($request->month)
                : now();

        $query = Overtime::selectRaw("
                    employee_id,
                    SUM(CASE WHEN type = 'OnDay' THEN 1 ELSE 0 END) as total_on,
                    SUM(CASE WHEN type = 'OffDay' THEN 1 ELSE 0 END) as total_off,
                    SUM(CASE WHEN shift = 'A' THEN 1 ELSE 0 END) as shift_a,
                    SUM(CASE WHEN shift = 'B' THEN 1 ELSE 0 END) as shift_b,
                    SUM(CASE WHEN shift = 'C' THEN 1 ELSE 0 END) as shift_c
                ")
            ->whereYear('date', $month->year)
            ->whereMonth('date', $month->month)
            ->groupBy('employee_id')
            ->with('employee');

        // 🔍 Search by employee name or employee number
        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('employee_number', 'like', '%'.$request->search.'%');
            });
        }

        $summary = $query->paginate(15)->withQueryString();

        return view('overtimes.summary', compact('summary', 'month'));
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
}
