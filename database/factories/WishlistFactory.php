<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Wishlist>
 */
class WishlistFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        /** @var User $user */
        $user = User::query()->role('customer')->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'name' => Str::ucfirst(fake()->word()),
        ];
    }
}
