<?php

namespace Database\Seeders;

use App\Models\Pago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagoSeeder extends Seeder
{

    public function run(): void
    {
        Pago::create([
            'apprentice_id' => 1,
            'monto' => 100000,
            'metodo_pago_id' => 1,
            'dinero' => 'Ingresado',
        ]);

        Pago::create([
            'apprentice_id' => 2,
            'monto' => 50000,
            'metodo_pago_id' => 2,
            'dinero' => 'Egresado',
        ]);
    }
}
