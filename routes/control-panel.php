<?php

use App\Http\Controllers\Dashboard\ControlPanelController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:web'],
    // 'prefix' => 'dashboard',
    // 'namespace' => 'Dashboard',
    // 'as' => 'dashboard.'
], function () {

    Route::get('/control-panel', [ControlPanelController::class, 'index'])->name('control-panel.index');

    Route::post('/control-panel/store', [ControlPanelController::class, 'store'])->name('control-panel.store');
});

