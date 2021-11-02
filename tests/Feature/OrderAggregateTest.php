<?php

declare(strict_types=1);

use Domains\Fulfilment\Aggregates\OrderAggregate;
use Domains\Fulfilment\Events\OrderStateWasUpdated;
use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;
use Domains\Fulfilment\Models\Order;
use Domains\Fulfilment\States\Statuses\OrderStatus;

it('can create an order for an unauthenticated user', function (CartItem $item, Location $location) {
    OrderAggregate::fake()
        ->given(
            events: new OrderWasCreated(
                cart:     $item->cart->uuid,
                shipping: $location->id,
                billing:  $location->id,
                user:     null,
                email:    'juststevemcd@gmail.com',
                intent: '12345',
            ),
        )->when(
            callable: function (OrderAggregate $aggregate) use($item, $location) {
              $aggregate->createOrder(
                  cart:     $item->cart->uuid,
                  shipping: $location->id,
                  billing:  $location->id,
                  user:     null,
                  email:    'juststevemcd@gmail.com',
                  intent: '12345',
              );
            },
        )->assertRecorded(
            expectedEvents: new OrderWasCreated(
                cart:     $item->cart->uuid,
                shipping: $location->id,
                billing:  $location->id,
                user:     null,
                email:    'juststevemcd@gmail.com',
                intent: '12345',
            )
        );
})->with('3CartItems', 'location');

it('can create an order for an authenticated user', function (CartItem $item, Location $location) {
    auth()->login(User::factory()->create());

    OrderAggregate::fake()
        ->given(
            events: new OrderWasCreated(
                cart:     $item->cart->uuid,
                shipping: $location->id,
                billing:  $location->id,
                user:     auth()->id(),
                email:    null,
                intent: '12345',
            ),
        )->when(
            callable: function (OrderAggregate $aggregate) use ($item, $location) {
                $aggregate->createOrder(
                    cart:     $item->cart->uuid,
                    shipping: $location->id,
                    billing:  $location->id,
                    user:     auth()->id(),
                    email:    null,
                    intent: '12345',
                );
            },
        )->assertRecorded(
            expectedEvents: new OrderWasCreated(
                cart:     $item->cart->uuid,
                shipping: $location->id,
                billing:  $location->id,
                user:     auth()->id(),
                email:    null,
                intent: '12345',
            )
        );
})->with('3CartItems', 'location');

it('can update an orders status', function () {
    auth()->login(User::factory()->create());

    $order = Order::factory()->create();

    OrderAggregate::fake(
        uuid: $order->uuid,
    )->given(
        events: new OrderStateWasUpdated(
            id: $order->id,
            state: OrderStatus::completed()->value,
        ),
    )->when(
        callable: function (OrderAggregate $aggregate) use ($order) {
            $aggregate->updateState(
                id: $order->id,
                state: OrderStatus::completed()->value,
            );
        },
    )->assertRecorded(
        expectedEvents: new OrderStateWasUpdated(
            id: $order->id,
            state: OrderStatus::completed()->value,
        ),
    );
});
