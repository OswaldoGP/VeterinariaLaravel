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

        User::create([
            'name' => 'veterinario',
            'email' => 'vet@vet.com',
            'password' => 'vet',
            'rol' => 'veterinario',
        ]);
    }
}
