<?php

namespace App\Providers;

use App\Models\{
    User,
    Admin,
};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Auth::viaRequest('custom-user', fn (Request $request) => User::find((int) $request->bearerToken()));
        Auth::viaRequest('custom-admin', fn (Request $request) => Admin::find((int) $request->bearerToken()));
    }
}
