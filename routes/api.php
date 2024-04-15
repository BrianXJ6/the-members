<?php

use App\Http\Controllers\{
    AdminController,
    TopicController,
};

use Illuminate\Support\Facades\Route;

Route::controller(AdminController::class)
    ->middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('topics', TopicController::class)->only('store', 'update', 'destroy');
        Route::post('create-user', 'createUser')->name('create-user');
    });

Route::resource('topics', TopicController::class)->only('index', 'show');
