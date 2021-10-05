<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\CouponFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasUuid;
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'reduction',
        'uses',
        'max_uses',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function newFactory(): \Database\Factories\CouponFactory
    {
        return CouponFactory::new();
    }
}
