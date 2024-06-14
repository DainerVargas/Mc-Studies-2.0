<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendant>
 */
class AttendantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /*  $table->string('name');
            $table->string('email');
            $table->string('telefono'); */
        return [
            'name' => fake()->name(),
            'apellido' => fake()->lastName(),
            'email' => fake()->email(),
            'telefono' => fake()->phoneNumber()
        ];
    }
}
