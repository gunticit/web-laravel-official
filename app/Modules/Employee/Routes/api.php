<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Modules\Employee\Controllers\EmployeeController;

Route::group([
    'prefix' => '',
    'middleware' => 'auth:api',
], function () {
    Route::resource('user', EmployeeController::class);
});