<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'Administrador Inventario',
            'email' => 'admin.nsp.2026@gmail.com',
            'password' => '12345678',
            'rol' => 'Administrador',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Mantenimiento',
            'email' => 'ffjhoan9@gmail.com',
            'password' => '12345678',
            'rol' => 'Mantenimiento',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Directiva',
            'email' => 'vallerobledojairjhoan@gmail.com',
            'password' => '12345678',
            'rol' => 'Directiva',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jhoan Valle',
            'email' => 'vallejhoan602@gmail.com',
            'password' => '12345678',
            'rol' => 'Administrador',
            'email_verified_at' => now(),
        ]);
    }
}