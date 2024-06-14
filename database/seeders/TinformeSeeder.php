<?php

namespace Database\Seeders;

use App\Models\Tinforme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TinformeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tinforme::create([
            'teacher_id' => 1,
            'abono' => 0,
            'fecha' => null
        ]);
        Tinforme::create([
            'teacher_id' => 2,
            'abono' => 0,
            'fecha' => null
        ]);
        Tinforme::create([
            'teacher_id' => 3,
            'abono' => 0,
            'fecha' => null
        ]);
    }
}
