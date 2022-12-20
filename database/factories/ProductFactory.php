<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => Str::ucfirst(fake()->unique()->word()),
            'description' => fake()->paragraph,
            'price' => fake()->numberBetween(1, 999),
            'quantity' => fake()->numberBetween(1, 100),
        ];
    }
}
