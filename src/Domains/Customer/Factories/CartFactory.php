<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\CartValueObject;

class CartFactory
{
    /**
     * @param array $attributes
     * @return CartValueObject
     */
    public static function make(array $attributes): CartValueObject
    {
        return new CartValueObject(
            status: $attributes['status'],
            userId: $attributes['user_id'],
        );
    }
}
