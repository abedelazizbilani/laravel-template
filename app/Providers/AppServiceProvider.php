<?php

namespace App\Providers;

use App\Http\ViewComposers\HeaderComposer;
use App\Models\User;
use Collective\Html\FormBuilder;
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
            'verifier', function () {
            $user = User::find(auth()->user()->id);
            return $user->hasRole(['verifier']);
        });

        Blade::if (
            'request', function ($url) {
            return request()->is($url);
        });

        Schema::defaultStringLength(191);

        FormBuilder::component('textField', 'components.form.text_field', ['name', 'value', 'attributes', 'label']);
        FormBuilder::component('numberField', 'components.form.number_field', ['name', 'value', 'attributes', 'label']);
        FormBuilder::component('passwordField', 'components.form.password_field', ['name', 'attributes', 'label']);
        FormBuilder::component('selectField', 'components.form.select_field', ['name', 'value', 'selected' ,'attributes', 'label']);
        FormBuilder::component('booleanField', 'components.form.boolean_field', ['name', 'value', 'checked', 'attributes', 'label']);
        FormBuilder::component('textareaField', 'components.form.textarea_field', ['name', 'value', 'attributes', 'label']);
        FormBuilder::component('submitField', 'components.form.submit_field', ['name', 'attributes']);

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
