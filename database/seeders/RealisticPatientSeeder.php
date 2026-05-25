<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Mascota;
use App\Models\Dueno;
use App\Models\Consulta;
use App\Models\Alergia;
use App\Models\Lesion;
use App\Models\Patologia;
use App\Models\Alimentacion;
use App\Models\Veterinario;
use Carbon\Carbon;

class RealisticPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clean up existing data to remove "firulais" and "frijol"
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Alimentacion::truncate();
        Patologia::truncate();
        Lesion::truncate();
        Alergia::truncate();
        Consulta::truncate();
        Mascota::truncate();
        Dueno::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Find a veterinarian to assign to the consultations
        $veterinario = Veterinario::first();
        
        // Fallback just in case there are no vets (though there should be based on previous work)
        if (!$veterinario) {
            $user = \App\Models\User::firstOrCreate(
                ['email' => 'vet@veternova.com'],
                ['name' => 'Dr. Vet', 'password' => bcrypt('password'), 'role' => 'veterinario']
            );
            $veterinario = Veterinario::create([
                'user_id' => $user->id,
                'especialidad' => 'Medicina General',
                'cedula_profesional' => '12345678',
                'telefono_contacto' => '5555555555',
            ]);
        }

        // 3. Create a realistic Owner
        $dueno = Dueno::create([
            'nombre_completo' => 'Carlos Mendoza Vargas',
            'telefono' => '55-8765-4321',
            'direccion' => 'Av. Insurgentes Sur 4521, Depto 3A, Col. Tlalpan Centro, CDMX',
        ]);

        // 4. Create a realistic Pet (Older dog with history)
        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Bruno',
            'especie' => 'Perro',
            'raza' => 'Golden Retriever',
            'fecha_nacimiento' => Carbon::now()->subYears(7)->subMonths(4)->toDateString(), // 7 years and 4 months old
            'tipo_sangre' => 'DEA 1.1 Negativo',
            'comportamiento' => 'Dócil pero ansioso en el veterinario. Tolera manipulación.',
            'es_adoptado' => false,
        ]);

        // 5. Add Medical History (Sidebar Modules)
        Alergia::create([
            'mascota_id' => $mascota->id,
            'nombre' => 'Alergia a la Penicilina',
            'descripcion' => 'Presentó shock anafiláctico leve a los 2 años tras aplicación de penicilina. ESTRICTAMENTE PROHIBIDO.',
            'created_at' => Carbon::now()->subYears(5),
            'updated_at' => Carbon::now()->subYears(5),
        ]);

        Alergia::create([
            'mascota_id' => $mascota->id,
            'nombre' => 'Alergia Alimentaria (Pollo)',
            'descripcion' => 'Dermatitis atópica y problemas gastrointestinales cuando consume proteína de pollo.',
            'created_at' => Carbon::now()->subYears(3),
            'updated_at' => Carbon::now()->subYears(3),
        ]);

        Lesion::create([
            'mascota_id' => $mascota->id,
            'tipo' => 'Ruptura de Ligamento Cruzado Anterior (Izquierdo)',
            'descripcion' => 'Ruptura parcial tratada con reposo y antiinflamatorios. No requirió cirugía pero camina con leve cojera en días fríos.',
            'created_at' => Carbon::now()->subMonths(18),
            'updated_at' => Carbon::now()->subMonths(18),
        ]);

        Patologia::create([
            'mascota_id' => $mascota->id,
            'nombre' => 'Osteoartritis temprana',
            'descripcion' => 'Desgaste articular en cadera y rodillas, normal para la edad y raza. Requiere control de peso y suplementos articulares.',
            'created_at' => Carbon::now()->subMonths(12),
            'updated_at' => Carbon::now()->subMonths(12),
        ]);

        Alimentacion::create([
            'mascota_id' => $mascota->id,
            'alimento' => 'Pro Plan Veterinary Diets - Hypoallergenic (Salmón)',
            'cantidad' => '350g',
            'frecuencia' => '2 veces al día (Mañana y Noche)',
            'observaciones' => 'No dar premios con pollo. Suplementar con Omega 3 y Condroitina en el desayuno.',
            'created_at' => Carbon::now()->subYears(3),
            'updated_at' => Carbon::now()->subYears(1),
        ]);

        // 6. Add a history of Consultations across several years
        
        // Consultation 1 (3 years ago - Allergy discovery)
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subYears(3)->subDays(15),
            'peso' => 32.50,
            'talla' => 61.00,
            'diagnostico' => "El paciente se presenta con prurito intenso, enrojecimiento en el vientre y heces sueltas.\nSe determina cuadro de dermatitis atópica de posible origen alimentario.\nSe suspende dieta habitual y se inicia dieta de descarte con proteína hidrolizada o salmón.\nSe prescribe tratamiento tópico para aliviar la picazón.",
        ]);

        // Consultation 2 (1.5 years ago - Lesion)
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subMonths(18)->subDays(5),
            'peso' => 34.00, // Gained weight
            'talla' => 61.00,
            'diagnostico' => "Propietario reporta cojera repentina en pata trasera izquierda tras jugar a atrapar la pelota en el parque.\nA la palpación hay dolor en la rodilla y signo de cajón levemente positivo.\nDiagnóstico presuntivo: Ruptura parcial de ligamento cruzado anterior.\nSe indican 4 semanas de reposo estricto, Meloxicam 1.5mg/ml, y dieta para reducción de peso para evitar sobrecarga articular.",
        ]);

        // Consultation 3 (1 year ago - Pathology discovery)
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subMonths(12),
            'peso' => 31.50, // Lost weight (good)
            'talla' => 61.00,
            'diagnostico' => "Chequeo geriátrico anual. El paciente ha bajado de peso satisfactoriamente tras la lesión previa.\nSe toman radiografías de cadera preventivas debido a la raza.\nSe observan signos de osteoartritis temprana (esclerosis subcondral leve).\nSe inicia tratamiento profiláctico con condroprotectores (Cosequin) de por vida.",
        ]);

        // Consultation 4 (Recent - Routine checkup)
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subDays(45),
            'peso' => 31.00,
            'talla' => 61.00,
            'diagnostico' => "Revisión general y refuerzo de vacunación anual (Múltiple y Rabia).\nSe revisa estado de la rodilla izquierda: estable, sin cojera evidente.\nExamen dental: Acumulación de sarro grado II en premolares. Se recomienda programar profilaxis dental en los próximos 6 meses.\nSe renueva receta de condroprotectores.",
        ]);

        // Consultation 5 (Very Recent - minor issue)
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subDays(2),
            'peso' => 31.20,
            'talla' => 61.00,
            'diagnostico' => "El paciente presenta secreción ocular amarillenta en el ojo derecho y conjuntiva inflamada.\nPrueba de fluoresceína: Negativa (sin úlceras corneales).\nDiagnóstico: Conjuntivitis bacteriana leve.\nTratamiento: Gotas oftálmicas con Tobramicina cada 8 horas por 7 días. Limpieza ocular con suero fisiológico.",
        ]);
    }
}
