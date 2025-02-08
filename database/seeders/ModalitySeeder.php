<?php

namespace Database\Seeders;

use App\Models\Modality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalitySeeder extends Seeder
{
    public function run(): void
    {
        Modality::create([
            'name' => 'Pago Mensual',
            'valor' => 900000,
        ]);
        Modality::create([
            'name' => 'Pago a dos cuotas',
            'valor' => 900000,
        ]);
        Modality::create([
            'name' => 'Pago Completo',
            'valor' => 810000,
        ]);
        Modality::create([
            'name' => 'Pago personalizado',
            'valor' => 0,
        ]);
    }
}
