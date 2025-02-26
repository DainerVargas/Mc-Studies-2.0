<?php

namespace Database\Seeders;

use App\Models\typeService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeServiceSeeder extends Seeder
{
    public function run(): void
    {
        typeService::create([
            'name' => 'Luz electrica'
        ]);
        typeService::create([
            'name' => 'Agua'
        ]);
        typeService::create([
            'name' => 'gas'
        ]);
    }
}
