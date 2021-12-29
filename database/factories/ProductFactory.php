<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(15),
            'available' => $this->faker->boolval(0,1),
            // 'creator_id' => $this->faker-
        ];
    }
}
