<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Projectors;

use Domains\Fulfilment\Actions\CreateOrder;
use Domains\Fulfilment\Actions\UpdateOrderState;
use Domains\Fulfilment\Events\OrderStateWasUpdated;
use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Fulfilment\Factories\OrderFactory;
use Domains\Fulfilment\Models\Order;
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
                'intent' => $event->intent,
            ],
        );

        CreateOrder::handle(
            object: $object,
        );
    }

    public function onOrderStateWasUpdated(OrderStateWasUpdated $event): void
    {
        $order = Order::query()->find(
            id: $event->id,
        );

        UpdateOrderState::handle(
            order: $order,
            state: $event->state,
        );
    }
}
