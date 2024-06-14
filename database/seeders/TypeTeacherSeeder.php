<?php

namespace Database\Seeders;

use App\Models\TypeTeacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeTeacher::create([
            'name' => 'Profesor'
        ]);

        TypeTeacher::create([
            'name' => 'Tutor'
        ]);
    }
}
