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
        Route::post('create-user', 'createUser')->name('create-user');
        Route::prefix('topics')->name('topics.')->group(function () {
            Route::post('/', 'storeTopic')->name('store');
            Route::put('{topic}', 'updateTopic')->name('update');
            Route::delete('{topic}', 'deleteTopic')->name('delete');
        });
    });

Route::controller(TopicController::class)
    ->prefix('topics')
    ->name('topics.')
    ->group(function () {
        Route::get('/', 'list')->name('list');
        Route::get('{topic}', 'show')->name('show');
        Route::prefix('{topic}/users')->name('users.')->group(function () {
            Route::get('/', 'subscribers')->name('subscribers');
        });
    });
