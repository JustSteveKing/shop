<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Models;

use Database\Factories\OrderFactory;
use Domains\Customer\Models\Location;
use Domains\Fulfilment\Models\OrderLine;
use Domains\Customer\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JustSteveKing\KeyFactory\Models\Concerns\HasKey;

class Order extends Model
{
    use HasKey;
    use HasFactory;

    protected $fillable = [
        'key',
        'number',
        'state',
        'coupon',
        'total',
        'reduction',
        'user_id',
        'shipping_id',
        'billing_id',
        'completed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function shipping(): BelongsTo
    {
        return $this->belongsTo(
            related: Location::class,
            foreignKey: 'shipping_id',
        );
    }

    public function billing(): BelongsTo
    {
        return $this->belongsTo(
            related: Location::class,
            foreignKey: 'billing_id',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(
            related: OrderLine::class,
            foreignKey: 'order_id',
        );
    }

    protected static function newFactory(): \Database\Factories\OrderFactory
    {
        return OrderFactory::new();
    }
}
