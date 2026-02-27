<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OvertimeController;
use App\Models\Employee;
use App\Models\Overtime;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    //remove  Route::resource('overtimes', OvertimeController::class);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// start dashboard with card

Route::get('/dashboard', function () {
    $totalEmployees = Employee::count();
    // $totalOvertime = Overtime::count();
    $totalOvertimeOnDay = Overtime::where('type', 'onDay')->count();
    $totalOvertimeOffDay = Overtime::where('type', 'offDay')->count();

// end dashboard card

    return view('dashboard', compact('totalEmployees', 'totalOvertimeOnDay', 'totalOvertimeOffDay'));
})->middleware(['auth'])->name('dashboard');

// new add
Route::middleware(['auth'])->group(function () {
    Route::resource('leaves', LeaveController::class)->middleware('auth');
});
// end new add

// new add
Route::middleware(['auth'])->group(function () {
   //remove Route::resource('overtimes', OvertimeController::class)->middleware('auth');
});
// end new add

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// add search option for name in overtime and leave
    Route::get('name_search', [OvertimeController::class, 'name_search'])
        ->middleware(['auth', 'verified'])
        ->name('name_search');
// end search option for name in overtime

// add search option for name in overtime
    Route::get('name_search', [LeaveController::class, 'name_search'])
        ->middleware(['auth', 'verified'])
        ->name('name_search');
// end search option for name in overtime

// add search option for name in Employee
    Route::get('name_search', [EmployeeController::class, 'name_search'])
        ->middleware(['auth', 'verified'])
        ->name('name_search');
// end search option for name in Employee

// use name box fo search name (overtime & Leave)
Route::get('/employee-search', [LeaveController::class, 'search']);

// add month filter for overtime
Route::get('overtimes/month', [OvertimeController::class, 'month'])
    ->name('overtimes.month');

    // Resource Route
//remove Route::resource('overtimes', OvertimeController::class);
// end month filter for overtime
Route::middleware(['auth'])->group(function () {

    // ✅ Month filter FIRST
    Route::get('overtimes/month', [OvertimeController::class, 'month'])
        ->name('overtimes.month');

    // ✅ Resource AFTER
    Route::resource('overtimes', OvertimeController::class);

});

require __DIR__.'/auth.php';
