<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $this->call([
            RolSeeder::class,
            AttendantSeeder::class,
            ModalitySeeder::class,
            TypeSeeder::class,
            TypeTeacherSeeder::class,
            TeacherSeeder::class,
            GroupSeeder::class,
            BecadoSeeder::class,
            LevelSeeder::class,
            SedeSeeder::class,
            ApprenticeSeeder::class,
            InformeSeeder::class,
            TinformeSeeder::class,
            AsistenciaSeeder::class,
            UserSeeder::class,
            TypeServiceSeeder::class,
            ServiceSeeder::class,
            AccountSeeder::class,
            MetodoPagoSeeder::class,
            PagoSeeder::class,
        ]);
    }
}
