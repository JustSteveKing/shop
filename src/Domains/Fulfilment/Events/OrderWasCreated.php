<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderWasCreated extends ShouldBeStored
{
    public function __construct(
        public string $cart,
        public int $shipping,
        public int $billing,
        public null|int $user,
        public null|string $email,
        public string $intent,
    ) {}
}
