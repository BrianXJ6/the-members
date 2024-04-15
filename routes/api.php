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
        // Apis resources
        Route::apiResources([
            'topics' => TopicController::class,
        ]);

        Route::post('create-user', 'createUser')->name('create-user');
    });
