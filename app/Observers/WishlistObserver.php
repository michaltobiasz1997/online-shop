<?php

namespace App\Observers;

use App\Models\Wishlist;

class WishlistObserver
{
    public function deleting(Wishlist $wishlist): void
    {
        $wishlist->products()->detach();
    }
}
