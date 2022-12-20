<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function deleting(Product $product): void
    {
        $product->wishlists()->detach();
    }
}
