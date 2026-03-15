<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Overtime;
use PDF;
use Excel;
use App\Exports\GenericExport;

class ExportController extends Controller
{
    public function export(Request $request, $type, $format)
    {
        $format = trim($format);
        switch ($type) {

            case 'employees':
                $data = Employee::all();
                break;

            case 'leaves':
                // $data = Leave::all();
                // break;
                $query = Leave::with('employee');

                // Search filter
                if ($request->filled('search')) {
                    $query->whereHas('employee', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('phone', 'like', '%' . $request->search . '%');
                    });
                }

                // Month filter
                if ($request->filled('month')) {
                    $month = \Carbon\Carbon::parse($request->month);
                    $query->whereYear('from_date', $month->year)
                        ->whereMonth('from_date', $month->month);
                }

                $data = $query->latest()->get();

                break;

            case 'overtimes':

                // break;
                $query = Overtime::with('employee');

                // Optional: apply same filters if needed
                if ($request->filled('search')) {
                    $query->whereHas('employee', function ($q) use ($request) {
                        $q->where('name', 'LIKE', '%' . $request->search . '%');
                    });
                }

                if ($request->filled('month')) {
                    $month = \Carbon\Carbon::parse($request->month);
                    $query->whereYear('date', $month->year)
                        ->whereMonth('date', $month->month);
                }

                $data = $query->latest()->get();

                break;

            case 'leave-summary':

                $query = Leave::join('employees', 'employees.id', '=', 'leaves.employee_id')
                    ->selectRaw("
                        employees.id as employee_id,
                        employees.name as employee_name,
                        SUM(CASE WHEN leaves.type = 'CL' THEN 1 ELSE 0 END) as CL,
                        SUM(CASE WHEN leaves.type = 'ML' THEN 1 ELSE 0 END) as ML,
                        SUM(CASE WHEN leaves.type = 'RL' THEN 1 ELSE 0 END) as RL
                    ")
                    ->groupBy('employees.id', 'employees.name');

                // 🔍 Search filter
                if ($request->filled('search')) {
                    $query->where('employees.name', 'like', '%' . $request->search . '%');
                }

                // 📅 Month filter (use SAME date column)
                if ($request->filled('month')) {
                    $month = \Carbon\Carbon::parse($request->month);

                    $query->whereYear('leaves.from_date', $month->year)
                        ->whereMonth('leaves.from_date', $month->month);
                }

                $data = $query->get();

                break;

            case 'overtime-summary':
                
                $data = $this->getOvertimeSummary($request);
                break;

            default:
                abort(404);
        }

        if ($format == 'pdf') {

            //Leave summary
            if ($type == 'leave-summary') {
                $pdf = PDF::loadView('exports.leave-summary-pdf', compact('data'));
                return $pdf->download('leave-summary.pdf');
            }

            //overtime summary
            if ($type == 'overtime-summary') {
                $pdf = PDF::loadView('exports.overtime-summary-pdf', compact('data'));
                return $pdf->download('overtime-summary.pdf');
            }
            
            // other exports 
            $pdf = PDF::loadView('exports.pdf', [
                'data' => $data,
                'type' => $type
            ]);
            return $pdf->download($type . '.pdf');
        }

        if ($format == 'excel') {

            //overtime summary excell
            if ($type == 'overtime-summary') {
                return Excel::download(
                    new GenericExport(
                        $data->map(function ($item) {
                            return [
                                'Employee Name' => $item->employee_name,
                                'Total OnDay'   => $item->total_on_day,
                                'Total OffDay'  => $item->total_off_day,
                            ];
                        })
                    ),
                    'overtime-summary.xlsx'
                );
            }
            //other exports excell 

            return Excel::download(new GenericExport($data), $type . '.xlsx');
        }

        abort(404);
    }
    
    //overtime summary query
    private function getOvertimeSummary(Request $request)
    {

        $month = $request->filled('month')
            ? \Carbon\Carbon::parse($request->month)
            : now();

        $query = Overtime::join('employees', 'employees.id', '=', 'overtimes.employee_id')
            ->selectRaw("
                employees.id as employee_id,
                employees.name as employee_name,
                SUM(CASE WHEN overtimes.type = 'OnDay' THEN 1 ELSE 0 END) as total_on_day,
                SUM(CASE WHEN overtimes.type = 'OffDay' THEN 1 ELSE 0 END) as total_off_day
            ")
            ->whereYear('overtimes.date', $month->year)
            ->whereMonth('overtimes.date', $month->month)
            ->groupBy('employees.id', 'employees.name');

        // 🔍 Search filter
        if ($request->filled('search')) {
            $query->where('employees.name', 'like', '%' . $request->search . '%');
        }

        return $query->get();
    }
}