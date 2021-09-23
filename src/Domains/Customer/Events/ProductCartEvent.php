<?php

declare(strict_types=1);

namespace Domains\Customer\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

abstract class ProductCartEvent extends ShouldBeStored
{
    public function __construct(
        public int $purchasableID,
        public int $cartID,
        public string $type,
    ) {}
}
