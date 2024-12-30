<?php

use App\Http\Controllers\Dashboard\AccreditationController;
use App\Http\Controllers\Dashboard\BankController;
use App\Http\Controllers\Dashboard\BanksEmployeesController;
use App\Http\Controllers\Dashboard\ConstantController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\CustomizationController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\ExchangeController;
use App\Http\Controllers\Dashboard\FixedEntriesController;
use App\Http\Controllers\Dashboard\LoanController;
use App\Http\Controllers\Dashboard\ReceivableController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SalaryController;
use App\Http\Controllers\Dashboard\SalaryScaleController;
use App\Http\Controllers\Dashboard\SavingController;
use App\Http\Controllers\Dashboard\TotalController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:web'],
    // 'prefix' => 'dashboard',
    // 'namespace' => 'Dashboard',
    // 'as' => 'dashboard.'
], function () {
    // outhers fields
    Route::get('/employees/getEmployee', [EmployeeController::class,'getEmployee'])->name('employees.getEmployee');
    Route::post('/employees/uplodeImage', [EmployeeController::class,'uplodeImage'])->name('employees.uplodeImage');
    Route::post('/employees/filterEmployee', [EmployeeController::class,'filterEmployee'])->name('employees.filterEmployee');


    Route::post('/fixed_entries/getData', [FixedEntriesController::class,'getData'])->name('fixed_entries.getData');
    Route::post('/loans/getData', [LoanController::class,'getData'])->name('loans.getData');


    Route::post('/exchanges/getTotals', [ExchangeController::class,'getTotals'])->name('exchanges.getTotals');


    Route::post('/salaries/createAllSalaries', [SalaryController::class,'createAllSalaries'])->name('salaries.createAllSalaries');
    Route::post('/salaries/deleteAllSalaries', [SalaryController::class,'deleteAllSalaries'])->name('salaries.deleteAllSalaries');
    Route::post('/salaries/getSalariesMonth', [SalaryController::class, 'getSalariesMonth'])->name('salaries.getSalariesMonth');



    // soft delete for salaries
    Route::get('/salaries/trashed', [SalaryController::class,'trashed'])->name('salaries.trashed');
    Route::put('/salaries/{salary}/restore', [SalaryController::class,'restore'])->name('salaries.restore');
    Route::delete('/salaries/{salary}/forceDelete', [SalaryController::class,'forceDelete'])->name('salaries.forceDelete');


    // Excel
    Route::post('employees/importExcel', [EmployeeController::class,'import'])->name('employees.importExcel');
    Route::get('employees/exportExcel', [EmployeeController::class,'export'])->name('employees.exportExcel');
    Route::post('banks_employees/importExcel', [BanksEmployeesController::class,'import'])->name('banks_employees.importExcel');
    Route::get('banks_employees/exportExcel', [BanksEmployeesController::class,'export'])->name('banks_employees.exportExcel');

    // PDF Export
    Route::post('employees/view_pdf', [EmployeeController::class, 'viewPDF'])->name('employees.view_pdf');
    Route::post('salaries/{salary}/view_pdf', [SalaryController::class, 'viewPDF'])->name('salaries.view_pdf');
    Route::post('receivables/{receivable}/view_pdf', [ReceivableController::class, 'print'])->name('receivables.view_pdf');
    Route::post('savings/{saving}/view_pdf', [SavingController::class, 'print'])->name('savings.view_pdf');
    Route::post('loans/{loan}/view_pdf', [LoanController::class, 'print'])->name('loans.view_pdf');
    Route::post('exchanges/{exchange}/printPdf', [ExchangeController::class,'printPdf'])->name('exchanges.printPdf');

    // sections seystem
    Route::get('/constants', [ConstantController::class,'index'])->name('constants.index');
    Route::post('/constants', [ConstantController::class,'store'])->name('constants.store');
    Route::delete('/constants/destroy', [ConstantController::class,'destroy'])->name('constants.destroy');


    // Report
    Route::get('/report', [ReportController::class,'index'])->name('report.index');
    Route::post('/report/export', [ReportController::class,'export'])->name('report.export');

    // specific_salaries
    require __DIR__ . "/specific_salaries.php";
    require __DIR__ . "/control-panel.php";

    Route::resources([
        'currencies' => CurrencyController::class,
        'employees' => EmployeeController::class,
        'banks' => BankController::class,
        'banks_employees' => BanksEmployeesController::class,
        'fixed_entries' => FixedEntriesController::class,
        'salary_scales' => SalaryScaleController::class,
        'salaries' => SalaryController::class,
        'users' => UserController::class,
        'exchanges' => ExchangeController::class,
        'customizations' => CustomizationController::class,
        'accreditations' => AccreditationController::class,
        'receivables' => ReceivableController::class,
        'savings' => SavingController::class,
        'loans' => LoanController::class,
        // 'roles' => RoleController::class,
    ]);
});

