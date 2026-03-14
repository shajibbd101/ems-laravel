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
        switch ($type) {

            case 'employees':
                $data = Employee::all();
                break;

            case 'leaves':
                $data = Leave::all();
                break;

            case 'overtimes':
                $data = Overtime::all();
                break;

            case 'overtime-summary':
                $data = Overtime::selectRaw('employee_id, 
                        SUM(total_on_day) as total_on_day,
                        SUM(total_off_day) as total_off_day')
                        ->groupBy('employee_id')
                        ->get();
                break;

            default:
                abort(404);
        }

        if ($format == 'pdf') {
            $pdf = PDF::loadView('exports.pdf', [
                'data' => $data,
                'type' => $type
            ]);
            return $pdf->download($type . '.pdf');
        }

        if ($format == 'excel') {
            return Excel::download(new GenericExport($data), $type . '.xlsx');
        }

        abort(404);
    }
}