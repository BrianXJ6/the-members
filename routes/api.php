<?php

use App\Http\Controllers\{
    UserController,
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

        // Group for topics
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

Route::controller(UserController::class)
    ->middleware('auth:user')
    ->prefix('users')
    ->name('users.')
    ->group(function () {
        // Group for topics
        Route::prefix('topics')->name('topics.')->group(function () {
            Route::get('/', 'topicList')->name('list');

            // Group for messages
            Route::prefix('{topic}/message')->name('messages.')->group(function () {
                Route::get('/', 'messageList')->name('list');
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

        // Group for users
        Route::prefix('{topic}/users')->name('users.')->group(function () {
            Route::get('/', 'subscribers')->name('subscribers');
            Route::post('/', 'subscriptions')->name('subscriptions');
        });

        // Group for messages
        Route::prefix('{topic}/messages')->name('messages.')->group(function () {
            Route::get('/', 'messages')->name('messages');
        });
    });
