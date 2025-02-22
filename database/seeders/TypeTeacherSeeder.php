<?php

namespace Database\Seeders;

use App\Models\TypeTeacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeTeacherSeeder extends Seeder
{

    public function run(): void
    {
        TypeTeacher::create([
            'name' => 'Profesor'
        ]);

        TypeTeacher::create([
            'name' => 'Tutor'
        ]);
        TypeTeacher::create([
            'name' => 'Gerente'
        ]);
        TypeTeacher::create([
            'name' => 'Asistente'
        ]);
        
        TypeTeacher::create([
            'name' => 'Secretaria'
        ]);
        TypeTeacher::create([
            'name' => 'Administrador'
        ]);
        TypeTeacher::create([
            'name' => 'Servicios Generales'
        ]);
    }
}
