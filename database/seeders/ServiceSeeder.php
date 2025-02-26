<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'name' => 'Luz electrica',
            'valor' => 155000,
            'fecha' => '2025-02-24',
            'type_service_id' => 1,
        ]);
        Service::create([
            'name' => 'Agua potable',
            'valor' => 89000,
            'fecha' => '2025-02-24',
            'type_service_id' => 2,
        ]);
        Service::create([
            'name' => 'gas natural',
            'valor' => 76000,
            'fecha' => '2025-02-24',
            'type_service_id' => 3,
        ]);
    }
}
