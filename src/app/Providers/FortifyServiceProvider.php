<?php

namespace App\Providers;

use Laravel\Fortify\Fortify;
use Illuminate\Support\ServiceProvider;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter as CacheRateLimiter;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });
    }
}