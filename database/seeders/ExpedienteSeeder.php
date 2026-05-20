<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Veterinario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Asegurarnos de tener un Veterinario disponible
        $veterinario = Veterinario::first();
        
        if (!$veterinario) {
            // Crear usuario temporal si no hay veterinarios
            $user = User::firstOrCreate(
                ['email' => 'vet_test@veterinaria.com'],
                [
                    'name' => 'Dr. Prueba',
                    'password' => Hash::make('password123'),
                ]
            );
            
            $veterinario = Veterinario::create([
                'user_id' => $user->id,
                'especialidad' => 'Medicina General',
                'cedula_profesional' => '12345678',
            ]);
        }

        // 2. Crear un Dueño
        $dueno = Dueno::create([
            'nombre_completo' => 'Juan Pérez',
            'telefono' => '555-123-4567',
            'direccion' => 'Calle Falsa 123, Colonia Centro',
        ]);

        // 3. Crear su Mascota
        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Firulais',
            'especie' => 'Canino',
            'raza' => 'Mestizo',
            'fecha_nacimiento' => Carbon::now()->subYears(3)->format('Y-m-d'), // 3 años de edad
            'tipo_sangre' => 'DEA 1.1 Positivo',
            'comportamiento' => 'Tranquilo y amigable',
            'es_adoptado' => true,
        ]);

        // 4. Crear 2 Consultas para esta mascota
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subMonths(2), // Hace 2 meses
            'peso' => 15.5,
            'talla' => 45.0,
            'diagnostico' => 'Revisión general de rutina. Presenta ligero sarro en los dientes.',
            'tratamiento' => 'Se sugiere limpieza dental en 6 meses. Mantener dieta actual.',
        ]);

        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subDays(5), // Hace 5 días
            'peso' => 15.8,
            'talla' => 45.0,
            'diagnostico' => 'Problema gastrointestinal leve por posible ingesta de algo en la calle.',
            'tratamiento' => 'Ayuno por 12 horas. Administrar probióticos y dieta blanda por 3 días.',
        ]);
    }
}
