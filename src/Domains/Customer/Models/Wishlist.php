<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\WishlistFactory;
use Domains\Catalog\Models\Variant;
use Domains\Customer\Models\Builders\WishlistBuilder;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'public',
        'user_id',
    ];

    protected $casts = [
        'public' => 'boolean',
    ];

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Variant::class,
            table: 'variant_wishlist',
        );
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    protected static function newFactory(): Factory
    {
        return WishlistFactory::new();
    }

    public function newEloquentBuilder($query): Builder
    {
        return new WishlistBuilder(
            query: $query,
        );
    }
}
