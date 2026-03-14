<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\ExportController;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Overtime;
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
    $totalEmployees = Employee::count();
    $totalOvertimeOnDay = Overtime::where('type', 'onDay')->count();
    $totalOvertimeOffDay = Overtime::where('type', 'offDay')->count();

    return view('dashboard', compact(
        'totalEmployees',
        'totalOvertimeOnDay',
        'totalOvertimeOffDay'
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

//Overtime Summary

Route::get('/overtime-summary', [OvertimeController::class, 'summary'])
    ->name('overtimes.summary');

//End Overtime Summary

//export routes
Route::get('/export/{type}/{format}', 
    [ExportController::class, 'export']
)->name('export.data');

require __DIR__.'/auth.php';