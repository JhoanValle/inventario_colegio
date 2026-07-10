<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ConfiguracionController;

use App\Http\Controllers\UsuarioController;

use App\Http\Controllers\AuditoriaController;
/*
|--------------------------------------------------------------------------
| INICIO
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| PERFIL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:administrador,directiva'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| EQUIPOS
|--------------------------------------------------------------------------
*/

/* VER EQUIPOS */
Route::get('/equipos', [EquipoController::class, 'index'])
    ->middleware(['auth', 'role:administrador,directiva,mantenimiento'])
    ->name('equipos.index');

/* CREAR */
Route::get('/equipos/create', [EquipoController::class, 'create'])
    ->middleware(['auth', 'role:administrador'])
    ->name('equipos.create');

Route::post('/equipos', [EquipoController::class, 'store'])
    ->middleware(['auth', 'role:administrador'])
    ->name('equipos.store');

/* EDITAR */
Route::get('/equipos/{equipo}/edit', [EquipoController::class, 'edit'])
    ->middleware(['auth', 'role:administrador'])
    ->name('equipos.edit');

Route::put('/equipos/{equipo}', [EquipoController::class, 'update'])
    ->middleware(['auth', 'role:administrador'])
    ->name('equipos.update');

/*
|--------------------------------------------------------------------------
| PROVEEDORES
|--------------------------------------------------------------------------
*/

Route::resource('proveedores', ProveedorController::class)
    ->middleware(['auth', 'role:administrador']);

Route::patch('/proveedores/{id}/estado',
    [ProveedorController::class, 'toggleEstado'])
    ->name('proveedores.estado');

/*
|--------------------------------------------------------------------------
| CATEGORIAS
|--------------------------------------------------------------------------
*/

Route::resource('categorias', CategoriaController::class)
    ->middleware(['auth', 'role:administrador']);

/*
|--------------------------------------------------------------------------
| MOVIMIENTOS
|--------------------------------------------------------------------------
*/

Route::get('/movimientos', [MovimientoController::class, 'index'])
    ->middleware(['auth', 'role:administrador'])
    ->name('movimientos.index');

/*
|--------------------------------------------------------------------------
| REPORTES
|--------------------------------------------------------------------------
*/

Route::get('/reportes', function () {
    return view('reportes.index');
})->middleware(['auth', 'role:administrador,directiva'])
  ->name('reportes.index');

Route::get('/exportar/equipos', [EquipoController::class, 'exportarEquipos'])
    ->middleware(['auth', 'role:administrador,directiva'])
    ->name('equipos.exportar');

Route::get('/exportar/movimientos', [EquipoController::class, 'exportarMovimientos'])
    ->middleware(['auth', 'role:administrador,directiva'])
    ->name('movimientos.exportar');

/*
|--------------------------------------------------------------------------
| CHATBOT IA
|--------------------------------------------------------------------------
*/

Route::get('/chatbot', [ChatbotController::class, 'index'])
    ->middleware(['auth', 'role:administrador,mantenimiento'])
    ->name('chatbot.index');

Route::post('/chatbot/preguntar', [ChatbotController::class, 'preguntar'])
    ->middleware(['auth', 'role:administrador,mantenimiento'])
    ->name('chatbot.preguntar');

/*
|--------------------------------------------------------------------------
| DIAGNOSTICOS
|--------------------------------------------------------------------------
*/

Route::get('/diagnosticos', [DiagnosticoController::class, 'index'])
    ->middleware(['auth', 'role:administrador,mantenimiento'])
    ->name('diagnosticos.index');

Route::get('/diagnosticos/pdf', [DiagnosticoController::class, 'pdf'])
    ->middleware(['auth', 'role:administrador,mantenimiento'])
    ->name('diagnosticos.pdf');

/*
|--------------------------------------------------------------------------
| PRESTAMOS
|--------------------------------------------------------------------------
*/

/* VER */
Route::get('/prestamos', [PrestamoController::class, 'index'])
    ->middleware(['auth', 'role:administrador,directiva'])
    ->name('prestamos.index');

/* CRUD SOLO ADMIN */
Route::resource('prestamos', PrestamoController::class)
    ->except(['index'])
    ->middleware(['auth', 'role:administrador']);

/*
|--------------------------------------------------------------------------
| CONFIGURACION
|--------------------------------------------------------------------------
*/

Route::get('/configuracion', [ConfiguracionController::class, 'index'])
    ->middleware(['auth', 'role:administrador'])
    ->name('configuracion.index');

Route::post('/configuracion', [ConfiguracionController::class, 'update'])
    ->middleware(['auth', 'role:administrador'])
    ->name('configuracion.update');

Route::middleware(['auth', 'role:administrador'])->group(function () {
    // Listado de usuarios
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    
    // Actualización de rol (usando PATCH para seguridad)
Route::patch('/usuarios/{usuario}/rol', [UsuarioController::class, 'updateRol'])->name('usuarios.updateRol');
});

Route::get('/usuarios/auditorias',
    [AuditoriaController::class, 'index']
)->name('auditorias.index');