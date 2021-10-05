<?php

declare(strict_types=1);

namespace Domains\Customer\Aggregates;

use Domains\Customer\Events\OrderWasCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregate extends AggregateRoot
{
    public function createOrder(string $cart, int $shipping, int $billing, null|int $user, null|string $email): self
    {
        $this->recordThat(
            domainEvent: new OrderWasCreated(
                cart: $cart,
                shipping: $shipping,
                billing: $billing,
                user: $user,
                email: $email,
            ),
        );

        return $this;
    }
}
