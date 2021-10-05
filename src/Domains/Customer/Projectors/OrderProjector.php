<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Actions\CreateOrder;
use Domains\Customer\Events\OrderWasCreated;
use Domains\Customer\Factories\OrderFactory;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
    public function onOrderWasCreated(OrderWasCreated $event): void
    {
        $object = OrderFactory::make(
            attributes: [
                'cart' => $event->cart,
                'billing' => $event->billing,
                'shipping' => $event->shipping,
                'email' => $event->email,
                'user' => $event->user,
            ],
        );

        CreateOrder::handle(
            object: $object,
        );
    }
}
