<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Aggregates;

use Domains\Fulfilment\Events\OrderWasCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregate extends AggregateRoot
{
    public function createOrder(
        string $cart,
        int $shipping,
        int $billing,
        null|int $user,
        null|string $email,
        string $intent,
    ): self
    {
        $this->recordThat(
            domainEvent: new OrderWasCreated(
                cart: $cart,
                shipping: $shipping,
                billing: $billing,
                user: $user,
                email: $email,
                intent: $intent,
            ),
        );

        return $this;
    }
}
