<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
            'email' => 'mcstudies@gmail.com',
            'password' => Hash::make('Mcstudies2024',),
            'rol_id' => 1,
        ]);

    }
}
