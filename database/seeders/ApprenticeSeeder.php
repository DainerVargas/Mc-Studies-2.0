<?php

namespace Database\Seeders;

use App\Models\Apprentice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprenticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apprentice::create([
            'name' => 'Dainer',
            'apellido' => 'Vargas',
            'edad' => '20',
            'fecha_nacimiento' => '2003/07/26',
            'estado' => '0',
            'email' => '',
            'telefono' => '',
            'Attendant_id' => 1,
            'modality_id' => 3,
            'group_id' => null
        ]);
        
        Apprentice::factory(2)->create();
    }
}
