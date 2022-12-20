<?php

namespace App\Models;

use App\Observers\WishlistObserver;
use Database\Factories\WishlistFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDZobov\PivotSoftDeletes\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class Wishlist.
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property User $user
 * @property Collection|Product[] $products
 */
class Wishlist extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @inheritdoc
     */
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        self::observe(WishlistObserver::class);
    }

    protected static function newFactory(): Factory
    {
        return WishlistFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->using(ProductWishlist::class)
            ->withPivot('id', 'sequence')
            ->orderByPivot('sequence')
            ->as('product_wishlist')
            ->withTimestamps()
            ->withSoftDeletes();
    }
}
