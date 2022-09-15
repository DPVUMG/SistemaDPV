<?php

namespace App\Providers;

use App\Comment;
use App\Company;
use App\ProductComment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts.navbars.sidebar', function ($view) {
            $nombre_empresa = !is_null(Company::where('system',true)->first()) ? Company::where('system',true)->first()->name : '';
            $view->with('nombre_empresa', $nombre_empresa);
        });

        view()->composer('layouts.navbars.sidebar', function ($view) {
            $slogan = !is_null(Company::where('system',true)->first()) ? Company::where('system',true)->first()->slogan : '';
            $view->with('slogan', $slogan);
        });

        view()->composer('layouts.navbars.sidebar', function ($view) {
            $logotipo = !is_null(Company::where('system',true)->first()) ? Company::where('system',true)->first()->logotipo : '';
            $view->with('logotipo', $logotipo);
        });

        view()->composer('layouts.footers.auth', function ($view) {
            $nombre_empresa = !is_null(Company::where('system',true)->first()) ? Company::where('system',true)->first()->name : '';
            $view->with('nombre_empresa', $nombre_empresa);
        });

        view()->composer('layouts.footers.guest', function ($view) {
            $nombre_empresa = !is_null(Company::where('system',true)->first()) ? Company::where('system',true)->first()->name : '';
            $view->with('nombre_empresa', $nombre_empresa);
        });

        view()->composer('auth.login', function ($view) {
            $facebook = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->facebook : '';
            $view->with('facebook', $facebook);
        });

        view()->composer('auth.login', function ($view) {
            $twitter = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->twitter : '';
            $view->with('twitter', $twitter);
        });

        view()->composer('auth.login', function ($view) {
            $instagram = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->instagram : '';
            $view->with('instagram', $instagram);
        });

        view()->composer('auth.login', function ($view) {
            $page = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->page : '';
            $view->with('page', $page);
        });
    }
}
