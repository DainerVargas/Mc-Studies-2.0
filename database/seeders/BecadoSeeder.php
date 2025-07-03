<?php

namespace Database\Seeders;

use App\Models\Becado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BecadoSeeder extends Seeder
{
    public function run(): void
    {
        Becado::create([
            'name' => 'si',
        ]);

        Becado::create([
            'name' => 'no',
        ]);
    }
}
