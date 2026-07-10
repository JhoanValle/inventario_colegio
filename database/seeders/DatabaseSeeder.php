<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Deshabilitar restricciones de llaves foráneas temporalmente
        Schema::disableForeignKeyConstraints();

        // 2. Usar delete() en lugar de truncate() para evitar el error de llave foránea
        User::query()->delete();

        // 3. Crear tus usuarios
        User::create([
            'name' => 'Administrador Inventario',
            'email' => 'admin.nsp.2026@gmail.com',
            'password' => Hash::make('12345678'),
            'rol' => 'administrador',
            'email_verified_at' => now(),
        ]);

        // ... (agrega el resto de tus usuarios aquí igual que antes)

        // 4. Volver a habilitar las restricciones
        Schema::enableForeignKeyConstraints();
    }
}