<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL; // <--- Importa esto

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
        // 🔥 Activa paginación con estilo Bootstrap
        Paginator::useBootstrap();

        // Forzar HTTPS en entorno de producción para evitar avisos de seguridad
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}