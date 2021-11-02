<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderStateWasUpdated extends ShouldBeStored
{
    public function __construct(
        public int $id,
        public string $state,
    ) {}
}
