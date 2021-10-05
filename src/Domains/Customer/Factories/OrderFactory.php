<?php

declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\OrderValueObject;

class OrderFactory
{
    public static function make(array $attributes): OrderValueObject
    {
        return new OrderValueObject(
            cart:     $attributes['cart'],
            shipping: $attributes['shipping'],
            billing:  $attributes['billing'],
            user:     $attributes['user'],
            email:    $attributes['email'],
        );
    }
}
