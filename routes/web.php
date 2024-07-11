<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.index');
})->name('home')->middleware('auth');
Route::match(['get','post'],'/pdf', function () {
    $employees = Employee::paginate(80);
    return view('dashboard.pdf.employees',compact('employees'));
});


require __DIR__ . "/dashobard.php";
