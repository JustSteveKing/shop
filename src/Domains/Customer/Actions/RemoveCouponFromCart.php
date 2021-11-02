<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Models\Cart;

class RemoveCouponFromCart
{
    public static function handle(Cart $cart): void
    {
        $cart->update([
            'coupon' => null,
            'reduction' => 0,
        ]);
    }
}
