<?php

namespace App\Actions\Wishlist;

use App\Models\Product;
use App\Models\Wishlist;

class DetachProductAction
{
    public function __invoke(Wishlist $wishlist, Product $product): Wishlist
    {
        $wishlist->products()->detach($product);

        return $wishlist->load('products');
    }
}
