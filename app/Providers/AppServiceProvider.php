<?php

namespace App\Providers;

use App\Http\ViewComposers\HeaderComposer;
use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

//use App\Http\ViewComposers\MenuComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setLocale(LC_TIME, config('app.locale'));

//        view()->composer('front/layout',MenuComposer::class);

        view()->composer('back/layout', HeaderComposer::class);

        Blade::if (
            'admin', function () {
            $user = User::find(auth()->user()->id);
            return $user->hasRole(['admin']);
        });

        Blade::if (
            'request', function ($url) {
            return request()->is($url);
        });

        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//
    }
}
