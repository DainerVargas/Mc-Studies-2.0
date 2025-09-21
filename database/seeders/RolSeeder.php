<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{

    public function run(): void
    {
        Rol::create([
            'name' => 'Gerente'
        ]);

        Rol::create([
            'name' => 'Secretaria'
        ]);

        Rol::create([
            'name' => 'Asistente'
        ]);
        Rol::create([
            'name' => 'Profesor'
        ]);
    }
}
