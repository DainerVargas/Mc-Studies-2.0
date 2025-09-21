<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeSeeder extends Seeder
{
    public function run(): void
    {
        Sede::create([
            'sede' => 'Fonseca',
        ]);

        Sede::create([
            'sede' => 'San juan',
        ]);

        Sede::create([
            'sede' => 'Online',
        ]);
    }
}
