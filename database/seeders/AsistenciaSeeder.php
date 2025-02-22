<?php

namespace Database\Seeders;

use App\Models\Asistencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        Asistencia::create([
            'fecha' => '2025-02-20',
            'estado' => 'presente',
            'observaciones' => 'El estudiante llegó puntual',
            'apprentice_id' => 1,
            'teacher_id' => 1,
            'group_id' => 1,
        ]);
        Asistencia::create([
            'fecha' => '2025-02-20',
            'estado' => 'ausente',
            'observaciones' => 'El estudiante no llegó',
            'apprentice_id' => 2,
            'teacher_id' => 1,
            'group_id' => 1,
        ]);
        Asistencia::create([
            'fecha' => '2025-02-20',
            'estado' => 'tarde',
            'observaciones' => 'El estudiante llegó tarde',
            'apprentice_id' => 3,
            'teacher_id' => 1,
            'group_id' => 1,
        ]);

        Asistencia::factory(8)->create();
    }
}
