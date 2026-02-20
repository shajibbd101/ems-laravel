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
}