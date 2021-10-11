<?php

use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Projectors\CartProjector;

beforeEach(fn() => $this->projector = new CartProjector());

it('can add a product to the cart', function (ProductWasAddedToCart $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->with(['items.purchasable'])->find($event->cartID);

    expect(
        $cart->items->count()
    )->toEqual(0);

    expect(
        $cart->total
    )->toEqual(0);

    $this->projector->onProductWasAddedToCart(
        event: $event,
    );

    $cart->refresh();

    expect(
        $cart->items->count()
    )->toEqual(1);

    expect(
        $cart->total
    )->toEqual($cart->items->first()->purchasable->retail);

})->with('AddedToCart');

it('can remove a product from the cart', function (ProductWasRemovedFromCart $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->with(['items.purchasable'])->find($event->cartID);

    expect(
        $cart->items->count()
    )->toEqual(1);

    $this->projector->onProductWasRemovedFromCart(
        event: $event,
    );

    $cart->refresh();

    expect(
        $cart->items->count()
    )->toEqual(0);

    expect(
        $cart->total
    )->toEqual(0);

})->with('RemovedFromCart');

it('can increase the quantity of an item in the cart', function (IncreaseCartQuantity $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->find($event->cartID);

    expect($cart->items->first()->quantity)->toEqual(1);

    $this->projector->onIncreaseCartQuantity(
        event: $event,
    );

})->with('IncreaseCartQuantity');
