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
    Route::resource('overtimes', OvertimeController::class);
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
    Route::resource('overtimes', OvertimeController::class)->middleware('auth');
});
// end new add

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// use name box fo search name (overtime & Leave)
Route::get('/employee-search', [LeaveController::class, 'search']);

require __DIR__.'/auth.php';
