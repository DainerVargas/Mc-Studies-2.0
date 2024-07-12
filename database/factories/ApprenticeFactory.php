<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apprentice>
 */
class ApprenticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'apellido' => fake()->lastName(),
            'edad' => rand(4,20),
            'fecha_nacimiento' => fake()->date('y-m-d'),
            'estado' => 0,
            'email' => $this->faker->email(),
            'telefono' => $this->faker->phoneNumber(),
            'Attendant_id' => rand(1,3),
            'modality_id' => rand(1,3),
            'group_id' => null
        ];
    }
}
