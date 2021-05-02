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

                Route::prefix('{accountId}')
                    ->group(function () {
                        Route::get('/', [
                            AccountsController::class,
                            'getView',
                        ]);
                        Route::post('/', [
                            AccountsController::class,
                            'postView',
                        ]);

                        Route::get('/transactions', [
                            TransactionsController::class,
                            'getIndex',
                        ]);
                        Route::get('/templates', [
                            TemplatesController::class,
                            'getIndex',
                        ]);

                        Route::prefix('tags')
                            ->group(function () {
                                Route::get('/', [
                                    TagsController::class,
                                    'getIndex',
                                ]);
                                Route::post('/', [
                                    TagsController::class,
                                    'postIndex',
                                ]);

                                Route::prefix('{tagId}')
                                    ->group(function () {
                                        Route::get('/', [
                                            TagsController::class,
                                            'getView',
                                        ]);
                                        Route::post('/', [
                                            TagsController::class,
                                            'postView',
                                        ]);

                                        Route::get('/deactivate', [
                                            TagsController::class,
                                            'getDeactivate',
                                        ]);
                                        Route::get('/activate', [
                                            TagsController::class,
                                            'getActivate',
                                        ]);
                                        Route::get('/delete', [
                                            TagsController::class,
                                            'getDelete',
                                        ]);
                                    });

                            });

                    });

            });

    });
