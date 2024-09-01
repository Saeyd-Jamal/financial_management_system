<?php

use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\SystemOperationsController;
use App\Livewire\TableSalaries;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/backup', [SystemOperationsController::class, 'createBackup'])->name('backup')->middleware('auth');


// Route::match(['get','post'],'/pdf', function () {
//     $employees = Employee::paginate(20);
//     return view('dashboard.pdf.employees',compact('employees'));
// });
Route::get('em', function () {
    return redirect()->route('em.home');
});

Route::group([
    'middleware' => ['auth:employee'],
    'prefix' => 'em',
], function () {
    Route::get('home', [EmployeeController::class,'index'])->name('em.home');
});

require __DIR__ . "/dashboard.php";
