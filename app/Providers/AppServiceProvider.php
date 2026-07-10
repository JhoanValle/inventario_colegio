<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator; // <-- Agregar esta línea
use App\Models\Configuracion;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        // 1. Configuración de HTTPS
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // 2. Configurar la paginación para Bootstrap 5
        Paginator::useBootstrapFive();

        // 3. Composición de vistas (Versión Segura)
        // Verificamos que la tabla exista antes de intentar consultar
        View::composer('*', function ($view) {
            $config = null;

            try {
                // Solo consultamos si la tabla realmente existe en la BD
                if (Schema::hasTable('configuracions')) {
                    $config = Configuracion::first();
                }
            } catch (\Throwable $e) {
                // Fallo silencioso si la BD no está disponible
            }

            $view->with('config', $config ?? new Configuracion());
        });
    }
}