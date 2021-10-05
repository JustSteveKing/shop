<?php

declare(strict_types=1);

namespace Domains\Customer\ValueObjects;

class OrderValueObject
{
    public function __construct(
        public string $cart,
        public int $shipping,
        public int $billing,
        public null|int $user,
        public null|string $email,
    ) {}
}
