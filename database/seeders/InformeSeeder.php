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
            'fecha' => null
        ]);
       /*  Informe::create([
            'apprentice_id' => 2,
            'abono' => 0,
            'fecha' => null
        ]);
        Informe::create([
            'apprentice_id' => 3,
            'abono' => 0,
            'fecha' => null
        ]); */
    }
}
