<?php

namespace Database\Seeders;

use App\Models\Attendant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendant::create([
            'name' => 'Mc-Studies',
            'apellido' => 'Languaje',
            'email' => 'info@mcstudies.com',
            'telefono' => '317 396 1175'
        ]);
        /* Attendant::factory(3)->create(); */
    }
}
