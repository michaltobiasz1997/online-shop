<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wishlist::factory()->count(10)->create()->each(function (Wishlist $wishlist) {
            $wishlist->products()->attach(Product::query()->inRandomOrder()->limit(5)->pluck('id'));
        });
    }
}
