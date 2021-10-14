<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Models;

use Database\Factories\OrderLineFactory;
use Domains\Fulfilment\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use JustSteveKing\KeyFactory\Models\Concerns\HasKey;

class OrderLine extends Model
{
    use HasKey;
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'retail',
        'cost',
        'quantity',
        'purchasable_id',
        'purchasable_type',
        'order_id',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            related: Order::class,
            foreignKey: 'order_id',
        );
    }

    public function purchasable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function newFactory(): \Database\Factories\OrderLineFactory
    {
        return OrderLineFactory::new();
    }
}
