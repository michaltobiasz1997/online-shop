<?php

namespace App\Models;

use App\Observers\ProductWishlistObserver;
use DDZobov\PivotSoftDeletes\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductWishlist.
 * @property int $id
 * @property int $product_id
 * @property int $wishlist_id
 * @property int $sequence
 * @property Product $product
 * @property Wishlist $wishlist
 */
class ProductWishlist extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @return bool
     */
    public $incrementing = true;

    protected static function booted(): void
    {
        self::observe(ProductWishlistObserver::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }
}
