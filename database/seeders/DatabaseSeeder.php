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
            ApprenticeSeeder::class,
            InformeSeeder::class,
            TinformeSeeder::class,
            AsistenciaSeeder::class, 
            UserSeeder::class,
            TypeServiceSeeder::class,
            ServiceSeeder::class,
            AccountSeeder::class,
        ]);
    }
}
