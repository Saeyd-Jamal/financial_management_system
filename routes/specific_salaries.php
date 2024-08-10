<?php

use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\SpecificSalaryController;
use App\Models\Employee;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::group([
    // 'middleware' => ['auth:web'],
    // 'prefix' => 'dashboard',
    // 'namespace' => 'Dashboard',
    // 'as' => 'dashboard.'
], function () {
    // النسبة
    Route::get('/specific_salaries/ratio', [SpecificSalaryController::class,'ratio'])->name('specific_salaries.ratio');
    Route::post('/specific_salaries/ratioCreate', [SpecificSalaryController::class,'ratioCreate'])->name('specific_salaries.ratioCreate');
    Route::post('/specific_salaries/getRatio', [SpecificSalaryController::class,'getRatio'])->name('specific_salaries.getRatio');

    // خاص
    Route::get('/specific_salaries/private', [SpecificSalaryController::class,'private'])->name('specific_salaries.private');
    Route::post('/specific_salaries/privateCreate', [SpecificSalaryController::class,'privateCreate'])->name('specific_salaries.privateCreate');

    // رياض
    Route::get('/specific_salaries/riyadh', [SpecificSalaryController::class,'riyadh'])->name('specific_salaries.riyadh');
    Route::post('/specific_salaries/riyadhCreate', [SpecificSalaryController::class,'riyadhCreate'])->name('specific_salaries.riyadhCreate');

    // فصلي
    Route::get('/specific_salaries/fasle', [SpecificSalaryController::class,'fasle'])->name('specific_salaries.fasle');
    Route::post('/specific_salaries/fasleCreate', [SpecificSalaryController::class,'fasleCreate'])->name('specific_salaries.fasleCreate');

    // المؤقت
    Route::get('/specific_salaries/interim', [SpecificSalaryController::class,'interim'])->name('specific_salaries.interim');
    Route::post('/specific_salaries/interimCreate', [SpecificSalaryController::class,'interimCreate'])->name('specific_salaries.interimCreate');

    // اليومي
    Route::get('/specific_salaries/daily', [SpecificSalaryController::class,'daily'])->name('specific_salaries.daily');
    Route::post('/specific_salaries/dailyCreate', [SpecificSalaryController::class,'dailyCreate'])->name('specific_salaries.dailyCreate');
});
