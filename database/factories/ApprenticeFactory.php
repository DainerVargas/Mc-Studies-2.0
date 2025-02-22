<?php

namespace Database\Factories;

use App\Models\Attendant;
use App\Models\Modality;
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
            'edad' => rand(4,40),
            'fecha_nacimiento' => fake()->date('y-m-d'),
            'estado' => fake()->randomElement([1,0]),
            'plataforma' => 0,
            'fechaPlataforma' => fake()->date('Y'),
            'valor' => fake()->randomElement([900000, 810000]),
            'descuento' => fake()->numberBetween(50000, 200000),
            'direccion' => $this->faker->address(),
            'email' => $this->faker->email(),
            'telefono' => $this->faker->phoneNumber(),
            'Attendant_id' => Attendant::pluck('id')->random(),
            'modality_id' => Modality::pluck('id')->random(),
            'group_id' => fake()->randomElement([1,2])
        ];
    }
}
