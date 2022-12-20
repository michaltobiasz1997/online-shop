<?php

namespace App\Models;

use App\Observers\UserObserver;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Collection|Wishlist[] $wishlists
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    /**
     * @inheritdoc
     */
    protected $guarded = ['id'];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        self::observe(UserObserver::class);
    }

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
