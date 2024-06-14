<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolSeeder::class,
            UserSeeder::class,
            AttendantSeeder::class,
            ModalitySeeder::class,
            TypeSeeder::class,
            TypeTeacherSeeder::class,
            TeacherSeeder::class,
            GroupSeeder::class,
            ApprenticeSeeder::class,
            InformeSeeder::class,
            TinformeSeeder::class
        ]);
    }
}
