<?php

namespace Database\Factories;

use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asistencia>
 */
class AsistenciaFactory extends Factory
{
    /**

     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => fake()->date('Y-m-d'),
            'estado' => fake()->randomElement(['presente','ausente','tarde']),
            'observaciones' => fake()->text(),
            'apprentice_id' => Apprentice::pluck('id')->random(),
            'teacher_id' => Teacher::pluck('id')->random(),
            'group_id' => Group::pluck('id')->random(),
        ];
    }
}
