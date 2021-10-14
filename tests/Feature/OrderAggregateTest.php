<?php

declare(strict_types=1);

use Domains\Fulfilment\Aggregates\OrderAggregate;
use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;

it('can create an order for an unauthenticated user', function (CartItem $item, Location $location) {
    OrderAggregate::fake()
        ->given(
            events: new OrderWasCreated(
                cart:     $item->cart->uuid,
                shipping: $location->id,
                billing:  $location->id,
                user:     null,
                email:    'juststevemcd@gmail.com',
            ),
        )->when(
            callable: function (OrderAggregate $aggregate) use($item, $location) {
              $aggregate->createOrder(
                  cart:     $item->cart->uuid,
                  shipping: $location->id,
                  billing:  $location->id,
                  user:     null,
                  email:    'juststevemcd@gmail.com',
              );
            },
        )->assertRecorded(
            expectedEvents: new OrderWasCreated(
                cart:     $item->cart->uuid,
                shipping: $location->id,
                billing:  $location->id,
                user:     null,
                email:    'juststevemcd@gmail.com',
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
            ),
        )->when(
            callable: function (OrderAggregate $aggregate) use($item, $location) {
                $aggregate->createOrder(
                    cart:     $item->cart->uuid,
                    shipping: $location->id,
                    billing:  $location->id,
                    user:     auth()->id(),
                    email:    null,
                );
            },
        )->assertRecorded(
            expectedEvents: new OrderWasCreated(
                cart:     $item->cart->uuid,
                shipping: $location->id,
                billing:  $location->id,
                user:     auth()->id(),
                email:    null,
            )
        );
})->with('3CartItems', 'location');
