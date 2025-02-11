<?php

namespace Database\Seeders;

use App\Models\Apprentice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class ApprenticeSeeder extends Seeder
{
    public function run(): void
    {
        Apprentice::create([
            'name' => 'Dainer',
            'apellido' => 'Vargas',
            'edad' => '20',
            'fecha_nacimiento' => '2003/07/26',
            'estado' => '0',
            'email' => '',
            'plataforma' => 0,
            'fechaPlataforma' => Date::now()->year,
            'valor' => 810000,
            'descuento' => 10000,
            'direccion' => 'calle 28',
            'telefono' => '3242406307',
            'Attendant_id' => 1,
            'modality_id' => 3,
            'group_id' => null
        ]);
        
        Apprentice::factory(2)->create();
    }
}
