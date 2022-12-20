<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Auth\Access\HandlesAuthorization;

class WishlistPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        if ($user->can('wishlists.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Wishlist $wishlist)
    {
        if ($user->can('wishlists.view')) {
            return $user->id === $wishlist->user_id;
        }
    }

    public function create(User $user)
    {
        if ($user->can('wishlists.create')) {
            return true;
        }
    }

    public function update(User $user, Wishlist $wishlist)
    {
        if ($user->can('wishlists.update')) {
            return $user->id === $wishlist->user_id;
        }
    }

    public function delete(User $user, Wishlist $wishlist)
    {
        if ($user->can('wishlists.delete')) {
            return $user->id === $wishlist->user_id;
        }
    }

    public function clear(User $user, Wishlist $wishlist)
    {
        if ($user->can('wishlists.clear')) {
            return $user->id === $wishlist->user_id;
        }
    }

    public function attachProduct(User $user, Wishlist $wishlist, Product $product)
    {
        if ($user->can('wishlists.products.attach')) {
            return $user->id === $wishlist->user_id && $wishlist->products->doesntContain($product) && $product->quantity > 0;
        }
    }

    public function detachProduct(User $user, Wishlist $wishlist)
    {
        if ($user->can('wishlists.products.detach')) {
            return $user->id === $wishlist->user_id;
        }
    }
}
