<?php

namespace App\Actions\Wishlist;

use App\Models\Product;
use App\Models\Wishlist;

class AttachProductAction
{
    public function __invoke(Wishlist $wishlist, Product $product): Wishlist
    {
        $wishlist->load('products');

        if ($wishlist->products->doesntContain($product)) {
            $wishlist->products()->attach($product);
        }

        return $wishlist->refresh();
    }
}
