<?php

namespace App\Providers;

use App\Models\Configuracion;
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

        /*$configuracion = Configuracion::where('sistema', true)->first();
        $mensaje = 'Configurar sistema';

        view()->composer('layouts.navbars.sidebar', function ($view) use ($configuracion, $mensaje) {
            if (!is_null($configuracion)) {
                $view->with('nombre_empresa', $configuracion->nombre);
                $view->with('slogan', $configuracion->slogan);
                $view->with('logotipo', $configuracion->getLogotipoPictureAttribute());
            } else {
                $view->with('nombre_empresa', $mensaje);
                $view->with('slogan', $mensaje);
                $view->with('logotipo', $mensaje);
            }
        });

        view()->composer('layouts.footers.auth', function ($view) use ($configuracion, $mensaje) {
            if (!is_null($configuracion)) {
                $view->with('nombre_empresa', $configuracion->nombre);
            } else {
                $view->with('nombre_empresa', $mensaje);
            }
        });

        view()->composer('layouts.footers.guest', function ($view) use ($configuracion, $mensaje) {
            if (!is_null($configuracion)) {
                $view->with('nombre_empresa', $configuracion->nombre);
            } else {
                $view->with('nombre_empresa', $mensaje);
            }
        });

        view()->composer('auth.login', function ($view) use ($configuracion, $mensaje) {
            if (!is_null($configuracion)) {
                $view->with('facebook', $configuracion->facebook);
                $view->with('twitter', $configuracion->twitter);
                $view->with('instagram', $configuracion->instagram);
                $view->with('page', $configuracion->url);
            } else {
                $view->with('facebook', $mensaje);
                $view->with('twitter', $mensaje);
                $view->with('instagram', $mensaje);
                $view->with('page', $mensaje);
            }
        });*/
    }
}
