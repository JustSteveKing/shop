<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\CartItemValueObject;

class CartItemFactory
{
    public static function make(array $attributes): CartItemValueObject
    {
        return new CartItemValueObject(
            quantity: $attributes['quantity'],
            purchasableId: $attributes['purchasable_id'],
            purchasableType: $attributes['purchasable_type']
        );
    }
}
