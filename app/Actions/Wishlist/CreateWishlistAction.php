<?php

namespace App\Actions\Wishlist;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class CreateWishlistAction
{
    public function __invoke(array $wishlistData): Wishlist
    {
        /** @var User $user */
        $user = Auth::user();

        return $user->wishlists()->create($wishlistData)->load('products');
    }
}
