<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'apellido' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'image' => null,
            'telefono' => fake()->phoneNumber(),
            'estado' => $this->faker->boolean,
            'type_teacher_id' => rand(1,2),
        ];
    }
}
