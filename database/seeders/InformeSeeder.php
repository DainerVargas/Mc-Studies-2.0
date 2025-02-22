<?php

namespace Database\Seeders;

use App\Models\Informe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Informe::create([
            'apprentice_id' => 1,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 2,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 3,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 4,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 5,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 6,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 7,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 8,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 9,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
        Informe::create([
            'apprentice_id' => 10,
            'abono' => 0,
            'fecha' => null,
            'fechaRegistro' => 2025
        ]);
    }
}
