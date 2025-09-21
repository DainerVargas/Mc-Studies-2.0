<?php

namespace Database\Seeders;

use App\Models\MetodoPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodoPagoSeeder extends Seeder
{
    public function run(): void
    {
        MetodoPago::create(
            [
                'name' => 'Efectivo'
            ]
        );
        MetodoPago::create(
            [
                'name' => 'Transferencia'
            ]
        );
    }
}
