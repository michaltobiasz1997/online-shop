<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Wishlist;

class UserObserver
{
    public function deleting(User $user): void
    {
        $user->wishlists->each(function (Wishlist $wishlist) {
            $wishlist->products()->detach();
            $wishlist->delete();
        });
    }
}
