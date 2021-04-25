<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\TemplatesController;
use App\Http\Controllers\TransactionsController;

Route::get('/', [LoginController::class, 'getIndex']);

Route::prefix('dashboard')
    ->group( function() {
        Route::get('/', [DashboardController::class, 'getIndex']);
        Route::get('/accounts', [AccountsController::class, 'getIndex']);
        Route::get('/templates', [TemplatesController::class, 'getIndex']);
        Route::get('/transactions', [TransactionsController::class, 'getIndex']);
    });
