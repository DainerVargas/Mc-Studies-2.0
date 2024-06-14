<?php

namespace Database\Seeders;

use App\Models\Modality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modality::create([
            'name' => 'Pago Mensual',
            'valor' => 200000,
        ]);
        Modality::create([
            'name' => 'Pago a dos cuotas',
            'valor' => 400000,
        ]);
        Modality::create([
            'name' => 'Pago Completo',
            'valor' => 720000,
        ]);
    }
}
