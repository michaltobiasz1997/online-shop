<?php

namespace App\Actions\Wishlist;

use App\Models\Wishlist;

class UpdateWishlistAction
{
    public function __invoke(Wishlist $wishlist, array $wishlistData): Wishlist
    {
        $wishlist->update([
            'name' => $wishlistData['name'],
        ]);

        return $wishlist->load('products');
    }
}
