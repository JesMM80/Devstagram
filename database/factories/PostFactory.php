<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(5),        // faker es una librería que rellena las tablas indicadas con datos de prueba.
            'descripcion' => $this->faker->sentence(28),
            'imagen' => $this->faker->uuid() . '.jpg',
            'user_id' => $this->faker->randomElement([2,4,10])
        ];
    }
}
