<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\TemplatesController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TagsController;

Route::get('/', [
    LoginController::class,
    'getIndex',
]);

Route::prefix('dashboard')
    ->group( function() {
        Route::get('/', [
            DashboardController::class,
            'getIndex',
        ]);

        Route::get('/accounts', [
            AccountsController::class,
            'getIndex',
        ]);
        Route::post('/accounts', [
            AccountsController::class,
            'postIndex',
        ]);

        Route::get('/accounts/{accountId}', [
            AccountsController::class,
            'getView',
        ]);
        Route::post('/accounts/{accountId}', [
            AccountsController::class,
            'postView',
        ]);

        Route::get('/accounts/{accountId}/transactions', [
            TransactionsController::class,
            'getIndex',
        ]);
        Route::get('/accounts/{accountId}/templates', [
            TemplatesController::class,
            'getIndex',
        ]);
        Route::get('/accounts/{accountId}/tags', [
            TagsController::class,
            'getIndex',
        ]);
    });
