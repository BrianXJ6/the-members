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

            // Group for users subscribed
            Route::prefix('{topic}/users/{user}')->name('users.')->group(function () {
                Route::post('subscribe', 'subscribe')->name('subscribe');
                Route::post('unsubscribe', 'unsubscribe')->name('unsubscribe');
            });

            // Group for messages
            Route::prefix('{topic}/message')->name('messages.')->group(function () {
                Route::post('/', 'sendMessage')->name('send');
            });
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
            Route::post('/', 'subscriptions')->name('subscriptions');
        });
        Route::prefix('{topic}/messages')->name('messages.')->group(function () {
            Route::get('/', 'messages')->name('messages');
        });
    });
