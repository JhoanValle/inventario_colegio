<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usamos updateOrCreate para evitar duplicados y errores en el despliegue
        User::updateOrCreate(
            ['email' => 'admin.nsp.2026@gmail.com'], // Llave única para verificar existencia
            [
                'name' => 'Administrador Inventario',
                'password' => Hash::make('12345678'),
                'rol' => 'administrador',
                'email_verified_at' => now(),
            ]
        );

        // Puedes agregar aquí otros seeders de forma similar:
        // $this->call([CategoriaSeeder::class]);
    }
}