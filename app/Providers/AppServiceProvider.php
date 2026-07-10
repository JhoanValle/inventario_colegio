<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL; // Importante: Asegúrate que esta línea esté aquí

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Activa paginación con estilo Bootstrap
        Paginator::useBootstrap();

        // Solución robusta para HTTPS en Railway
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}