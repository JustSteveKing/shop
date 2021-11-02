<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\WishlistValueObject;

class WishlistFactory
{
    public static function make(array $attributes): WishlistValueObject
    {
        return new WishlistValueObject(
            name: $attributes['name'],
            public: $attributes['public'],
            user: $attributes['user'],
        );
    }
}
