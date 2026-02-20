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
}