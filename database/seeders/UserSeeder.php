<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::create([
            'name' => 'Dainer Vargas',
            'usuario' => 'Dainer',
            'email' => 'dainer2607@gmail.com',
            'password' => Hash::make('Vargas2607'),
            'rol_id' => 1,
        ]);

        User::create([
            'name' => 'Mc-Studies',
            'usuario' => 'Mcstudies',
            'email' => 'info@mcstudies.com',
            'password' => Hash::make('Mcstudies2024',),
            'rol_id' => 1,
        ]);
        User::create([
            'name' => 'Secretaria',
            'usuario' => 'secre',
            'email' => 'secre@gmail.com',
            'password' => Hash::make('secre2025',),
            'rol_id' => 2,
        ]);

        User::create([
            'name' => 'asistente',
            'usuario' => 'asistente',
            'email' => 'asistente@gmail.com',
            'password' => Hash::make('asistente2025',),
            'rol_id' => 3,
        ]);

        User::create([
            'name' => 'Profesor',
            'usuario' => 'Profesor',
            'email' => 'profesor@gmail.com',
            'password' => Hash::make('Profesor2025',),
            'rol_id' => 4,
        ]);

    }
}
