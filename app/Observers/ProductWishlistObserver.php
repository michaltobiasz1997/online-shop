<?php

namespace App\Observers;

use App\Models\ProductWishlist;

class ProductWishlistObserver
{
    public function creating(ProductWishlist $productWishlist): void
    {
        $productWishlist->sequence = ProductWishlist::withTrashed()->where('wishlist_id', $productWishlist->wishlist_id)->max('sequence') + 1;
    }
}
