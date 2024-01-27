<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Product;
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

    public function configure()
    {
        return $this->afterCreating(function (Product $product){
            $file = new File(['route' => '/storage/images/products/default.png']);
            $product->file()->save($file);
        });
    }
}
