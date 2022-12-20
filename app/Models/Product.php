<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDZobov\PivotSoftDeletes\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Product.
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Collection | Wishlist[] $wishlists
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @inheritdoc
     */
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        self::observe(ProductObserver::class);
    }

    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }

    public function wishlists(): BelongsToMany
    {
        return $this->belongsToMany(Wishlist::class)
            ->using(ProductWishlist::class)
            ->withPivot('id', 'sequence')
            ->orderByPivot('sequence')
            ->as('product_wishlist')
            ->withTimestamps()
            ->withSoftDeletes();
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }
}
