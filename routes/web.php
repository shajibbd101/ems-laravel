<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\ProfileController;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Overtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $currentMonth = now()->month;
    $currentYear = now()->year;

    $totalEmployees = Employee::count();
    $totalSalaryCost = Employee::sum('salary');

    $monthlyOvertimeOnDay = Overtime::whereMonth('date', $currentMonth)
        ->whereYear('date', $currentYear)
        ->where('type', 'OnDay')
        ->count();
    $monthlyOvertimeOffDay = Overtime::whereMonth('date', $currentMonth)
        ->whereYear('date', $currentYear)
        ->where('type', 'OffDay')
        ->count();

    $monthlyCL = Leave::whereMonth('from_date', $currentMonth)
        ->whereYear('from_date', $currentYear)
        ->where('type', 'CL')
        ->count();
    $monthlyML = Leave::whereMonth('from_date', $currentMonth)
        ->whereYear('from_date', $currentYear)
        ->where('type', 'ML')
        ->count();
    $monthlyRL = Leave::whereMonth('from_date', $currentMonth)
        ->whereYear('from_date', $currentYear)
        ->where('type', 'RL')
        ->count();

    $recentEmployees = Employee::latest()->take(5)->get();
    $recentOvertimes = Overtime::with('employee')->latest()->take(5)->get();
    $recentLeaves = Leave::with('employee')->latest()->take(5)->get();

    $topOvertimeEmployees = Employee::withCount(['overtimes' => function ($q) use ($currentMonth, $currentYear) {
        $q->whereMonth('date', $currentMonth)->whereYear('date', $currentYear);
    }])->orderBy('overtimes_count', 'desc')->take(5)->get();

    $topLeaveEmployees = Employee::withCount(['leaves' => function ($q) use ($currentMonth, $currentYear) {
        $q->whereMonth('from_date', $currentMonth)->whereYear('from_date', $currentYear);
    }])->orderBy('leaves_count', 'desc')->take(5)->get();

    return view('dashboard', compact(
        'totalEmployees',
        'totalSalaryCost',
        'monthlyOvertimeOnDay',
        'monthlyOvertimeOffDay',
        'monthlyCL',
        'monthlyML',
        'monthlyRL',
        'recentEmployees',
        'recentOvertimes',
        'recentLeaves',
        'topOvertimeEmployees',
        'topLeaveEmployees',
        'currentMonth',
        'currentYear'
    ));
})->middleware(['auth'])->name('dashboard');

// Leave search route for autocomplete
Route::get('/employee-search', function (Request $request) {
    $query = $request->get('query');

    $employees = Employee::where('name', 'LIKE', "%{$query}%")
        ->limit(5)
        ->get();

    return response()->json($employees);
});
// Overtime search route for autocomplete Endpoint

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    | Employees
    */
    Route::get('employees/search', [EmployeeController::class, 'name_search'])
        ->name('employees.search');
    Route::resource('employees', EmployeeController::class);

    /*
    | Leaves
    */
    Route::get('leaves/search', [LeaveController::class, 'name_search'])
        ->name('leaves.search');
    Route::resource('leaves', LeaveController::class);

    /*
    | Overtimes
    */
    Route::get('overtimes/search', [OvertimeController::class, 'index'])
        ->name('overtimes.search');
    Route::get('overtimes/month', [OvertimeController::class, 'month'])
        ->name('overtimes.month');
    Route::resource('overtimes', OvertimeController::class);

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// Overtime Summary

Route::get('/overtime-summary', [OvertimeController::class, 'summary'])
    ->name('overtimes.summary');

// End Overtime Summary

// leave summary
Route::get('/leave-summary', [LeaveController::class, 'summary'])
    ->name('leaves.summary');

// end leave summary

// export routes
Route::get('/export/{type}/{format}',
    [ExportController::class, 'export']
)->name('export.data');

require __DIR__.'/auth.php';
