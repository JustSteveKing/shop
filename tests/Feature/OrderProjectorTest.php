<?php

declare(strict_types=1);

use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Fulfilment\Events\OrderStateWasUpdated;
use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Fulfilment\Models\Order;
use Domains\Fulfilment\Projectors\OrderProjector;

beforeEach(fn() => $this->projector = new OrderProjector());

it('can create a new order', function () {
    expect($this->projector)->toBeInstanceOf(OrderProjector::class);

    $cartItem = CartItem::factory()->create();
    $location = Location::factory()->create();

    expect(Order::query()->count())->toEqual(0);

    $this->projector->onOrderWasCreated(
        event: new OrderWasCreated(
            cart: $cartItem->cart->uuid,
            shipping: $location->id,
            billing: $location->id,
            user: null,
            email: 'test@test.com',
            intent: 'test',
        ),
    );

    expect(Order::query()->count())->toEqual(1);
});

it('can update the state of an order', function (string $state) {
    expect($this->projector)->toBeInstanceOf(OrderProjector::class);

    $order = Order::factory()->create();

    $this->projector->onOrderStateWasUpdated(
        event: new OrderStateWasUpdated(
            id: $order->id,
            state: $state
        ),
    );

    expect($order->refresh()->state)->toBe($state);
})->with('States');

