<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AdminLeaveController;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::get('/me',      [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('leave')->group(function () {
        Route::get('/',        [LeaveController::class, 'solde']);
        Route::post('/request',[LeaveController::class, 'request']);
    });

    Route::middleware('checkrole:admin')->prefix('admin/leave')->group(function () {
        Route::post('/{user}/credit', [AdminLeaveController::class, 'credit']);
        Route::post('/{user}/debit',  [AdminLeaveController::class, 'debit']);
    });
});
