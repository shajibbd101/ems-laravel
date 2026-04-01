<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {

        $query = Leave::with('employee');
        // Name Search
        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%');
            });
        }

        if ($request->search) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%');
            });
        }

        // Month filter
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);

            $query->whereYear('from_date', $month->year)
                ->whereMonth('to_date', $month->month);
        }

        $leaves = $query->latest()
            ->paginate(15)
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
        $request->merge([
            'from_date' => $this->convertDate($request->from_date),
            'to_date' => $this->convertDate($request->to_date),
        ]);

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required',
            'from_date' => 'required|date_format:Y-m-d',
            'to_date' => 'required|date_format:Y-m-d|after_or_equal:from_date',
        ]);

        $existingLeave = Leave::where('employee_id', $request->employee_id)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('from_date', '<=', $request->from_date)
                        ->where('to_date', '>=', $request->from_date);
                })->orWhere(function ($q) use ($request) {
                    $q->where('from_date', '<=', $request->to_date)
                        ->where('to_date', '>=', $request->to_date);
                })->orWhere(function ($q) use ($request) {
                    $q->where('from_date', '>=', $request->from_date)
                        ->where('to_date', '<=', $request->to_date);
                });
            })
            ->first();

        $days = \Carbon\Carbon::parse($request->from_date)
            ->diffInDays(\Carbon\Carbon::parse($request->to_date)) + 1;

        if ($existingLeave) {
            $employee = Employee::find($request->employee_id);

            return redirect()->back()
                ->withInput()
                ->with('employee_name', $employee->name ?? '')
                ->with('error', 'Leave already exists for this employee on the selected date range!');
        }

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

        $request->merge([
            'from_date' => $this->convertDate($request->from_date),
            'to_date' => $this->convertDate($request->to_date),
        ]);

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
                    $q->where('name', 'like', '%'.$request->search.'%');
                });
            })
            ->orderBy('id', 'desc')   // ✅ keep consistent order
            ->paginate(15)
            ->withQueryString();

        return view('leaves.index', compact('leaves'));
    }
    // end

    // leave summary
    public function summary(Request $request)
    {
        $month = $request->filled('month')
                ? Carbon::parse($request->month)
                : now();

        $query = Leave::selectRaw("
                    employee_id,
                    SUM(CASE WHEN type = 'CL' THEN days ELSE 0 END) as CL,
                    SUM(CASE WHEN type = 'ML' THEN days ELSE 0 END) as ML,
                    SUM(CASE WHEN type = 'RL' THEN days ELSE 0 END) as RL
                ")
            ->whereYear('from_date', $month->year)
            ->whereMonth('to_date', $month->month)
            ->groupBy('employee_id')
            ->with('employee');

        // 🔍 Search by employee name
        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            });
        }

        $summary = $query->paginate(15)->withQueryString();

        return view('leaves.summary', compact('summary', 'month'));
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
