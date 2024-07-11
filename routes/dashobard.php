<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\BankController;
use App\Http\Controllers\Dashboard\BanksEmployeesController;
use App\Http\Controllers\Dashboard\ConstantController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\FixedEntriesController;
use App\Http\Controllers\Dashboard\NatureWorkIncreaseController;
use App\Http\Controllers\Dashboard\SalaryController;
use App\Http\Controllers\Dashboard\SalaryScaleController;
use App\Http\Controllers\Dashboard\TotalController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WorkDataController;
use App\Http\Controllers\SystemOperationsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:web'],
    // 'prefix' => 'dashboard',
    // 'namespace' => 'Dashboard',
    // 'as' => 'dashboard.'
], function () {
    // outhers fields
    Route::post('/employees/getEmployee', [EmployeeController::class,'getEmployee'])->name('employees.getEmployee');
    Route::post('/fixed_entries/association_loan', [FixedEntriesController::class,'associationLoan'])->name('fixed_entries.associationLoan');
    Route::post('/fixed_entries/getFixedEntriesData', [FixedEntriesController::class,'getFixedEntriesData'])->name('fixed_entries.getFixedEntriesData');
    Route::post('/bakcups/getDataAll', [SystemOperationsController::class,'bakcupsData'])->name('bakcups.bakcupsData');




    // soft delete for salaries
    Route::get('/salaries/trashed', [SalaryController::class,'trashed'])->name('salaries.trashed');
    Route::put('/salaries/{salary}/restore', [SalaryController::class,'restore'])->name('salaries.restore');
    Route::delete('/salaries/{salary}/forceDelete', [SalaryController::class,'forceDelete'])->name('salaries.forceDelete');


    // Excel
    Route::post('/employees/importExcel', [EmployeeController::class,'import'])->name('employees.importExcel');

    // PDF Export
    Route::post('employees/view_pdf', [EmployeeController::class, 'viewPDF'])->name('employees.view_pdf');
    Route::post('salaries/view_pdf', [SalaryController::class, 'viewPDF'])->name('salaries.view_pdf');

    // sections seystem
    Route::get('/constants', [ConstantController::class,'index'])->name('constants.index');
    Route::post('/constants', [ConstantController::class,'store'])->name('constants.store');
    Route::delete('/constants/destroy', [ConstantController::class,'destroy'])->name('constants.destroy');

    Route::resources([
        'currencies' => CurrencyController::class,
        'employees' => EmployeeController::class,
        'banks' => BankController::class,
        'banks_employees' => BanksEmployeesController::class,
        'fixed_entries' => FixedEntriesController::class,
        'nature_work_increases' => NatureWorkIncreaseController::class,
        'salary_scales' => SalaryScaleController::class,
        'totals' => TotalController::class,
        'salaries' => SalaryController::class,
        'users' => UserController::class,
    ]);
});

