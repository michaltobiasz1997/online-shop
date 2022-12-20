<?php

namespace App\Actions\Wishlist;

use App\Models\Product;
use App\Models\Wishlist;

class ClearWishlistAction
{
    public function __invoke(Wishlist $wishlist): Wishlist
    {
        $wishlist->products()->detach();

        return $wishlist->load('products');
    }
}
