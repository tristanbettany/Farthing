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

        Route::prefix('accounts')
            ->group(function () {
                Route::get('/', [
                    AccountsController::class,
                    'getIndex',
                ]);
                Route::post('/', [
                    AccountsController::class,
                    'postIndex',
                ]);
            });

        Route::prefix('accounts/{accountId}')
            ->group(function () {
                Route::get('/', [
                    AccountsController::class,
                    'getView',
                ]);
                Route::post('/', [
                    AccountsController::class,
                    'postView',
                ]);
            });

        Route::prefix('accounts/{accountId}/transactions')
            ->group(function () {
                Route::get('/', [
                    TransactionsController::class,
                    'getIndex',
                ]);
                Route::post('/', [
                    TransactionsController::class,
                    'postIndex',
                ]);
            });

        Route::prefix('accounts/{accountId}/templates')
            ->group(function () {
                Route::get('/', [
                    TemplatesController::class,
                    'getIndex',
                ]);
                Route::post('/', [
                    TemplatesController::class,
                    'postIndex',
                ]);
            });

        Route::prefix('accounts/{accountId}/templates/{templateId}')
            ->group(function () {
                Route::get('/deactivate', [
                    TemplatesController::class,
                    'getDeactivate',
                ]);
                Route::get('/activate', [
                    TemplatesController::class,
                    'getActivate',
                ]);
                Route::get('/delete', [
                    TemplatesController::class,
                    'getDelete',
                ]);
            });

        Route::prefix('accounts/{accountId}/tags')
            ->group(function () {
                Route::get('/', [
                    TagsController::class,
                    'getIndex',
                ]);
                Route::post('/', [
                    TagsController::class,
                    'postIndex',
                ]);
            });

        Route::prefix('accounts/{accountId}/tags/{tagId}')
            ->group(function () {
                Route::get('/', [
                    TagsController::class,
                    'getView',
                ]);
                Route::post('/', [
                    TagsController::class,
                    'postView',
                ]);
                Route::get('/delete', [
                    TagsController::class,
                    'getDelete',
                ]);
            });

    });
