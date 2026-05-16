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
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'rol' => 'administrador',
        ]);

        $vet = User::create([
            'name' => 'veterinario',
            'email' => 'vet@vet.com',
            'password' => 'vet',
            'rol' => 'veterinario',
        ]);

        \App\Models\Veterinario::create([
            'user_id' => $vet->id,
            'especialidad' => 'General',
            'telefono' => '1234567890',
            'cedula_profesional' => 'CED-123456'
        ]);
    }
}
