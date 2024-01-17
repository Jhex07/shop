<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    public function definition()
    {
        return [
            'category_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'stock' => $this->faker->randomDigit(),
            'price' => $this->faker->numberBetween(10000, 500000),
        ];
    }
}
