<?php

use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\SystemOperationsController;
use App\Models\Employee;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/backup', [SystemOperationsController::class, 'createBackup'])->name('backup')->middleware('auth');


Route::match(['get','post'],'/pdf', function () {
    $employees = Employee::paginate(20);
    return view('dashboard.pdf.employees',compact('employees'));
});


require __DIR__ . "/dashboard.php";
