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
            'valor' => 300000,
        ]);
        Modality::create([
            'name' => 'Pago a dos cuotas',
            'valor' => 450000,
        ]);
        Modality::create([
            'name' => 'Pago Completo',
            'valor' => 810000,
        ]);
    }
}
