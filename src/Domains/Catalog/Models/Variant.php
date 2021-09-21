<?php

declare(strict_types=1);

namespace Domains\Catalog\Models;

use Database\Factories\VariantFactory;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\OrderLine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use JustSteveKing\KeyFactory\Models\Concerns\HasKey;

class  Variant extends Model
{
    use HasKey;
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'cost',
        'retail',
        'height',
        'width',
        'length',
        'weight',
        'active',
        'shippable',
        'product_id',
    ];

    protected $casts = [
        'active' => 'boolean',
        'shippable' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            related: Product::class,
            foreignKey: 'product_id',
        );
    }

    public function purchases(): MorphMany
    {
        return $this->morphMany(
            related: CartItem::class,
            name: 'purchasable',
        );
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(
            related: OrderLine::class,
            name: 'purchasable',
        );
    }

    protected static function newFactory(): Factory
    {
        return VariantFactory::new();
    }
}
