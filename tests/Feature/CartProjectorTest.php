<?php

use Domains\Customer\Events\CouponWasApplied;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Projectors\CartProjector;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

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

it('can remove a product with quantity > 1 from the cart', function (Cart $cart) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart->load(['items.purchasable']);

    /** @var CartItem $item */
    $item = $cart->items->first();
    $expectedTotal = $cart->total - ($item->quantity * $item->purchasable->retail);

    expect($cart)
        ->items->count()->toBe(3)
        ->items->first()->quantity->toBe(2);

    $this->projector->onProductWasRemovedFromCart(
        event: new ProductWasRemovedFromCart(
            purchasableID: $item->id,
            cartID: $cart->id,
            type: 'variant',
        ),
    );

    $cart->refresh();

    expect($cart)
        ->items->count()->toBe(2)
        ->total->toBe($expectedTotal);

})->with('CartWith3Items');

it('can increase the quantity of an item in the cart', function (IncreaseCartQuantity $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->find($event->cartID);

    expect($cart->items->first()->quantity)->toEqual(1);

    $this->projector->onIncreaseCartQuantity(
        event: $event,
    );

    $cart->refresh();

    expect($cart->items->first()->quantity)->toEqual(2);

})->with('IncreaseCartQuantity');

it('can decrease the quantity of an item in the cart', function (DecreaseCartQuantity $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->find($event->cartID);

    expect($cart->items->first()->quantity)->toEqual(3);

    $this->projector->onDecreaseCartQuantity(
        event: $event,
    );

    $cart->refresh();

    expect($cart->items->first()->quantity)->toEqual(1);

})->with('DecreaseCartQuantity');

it('removes the item from the cart when you are trying to remove more than or equal to the quantity in the cart', function (DecreaseCartQuantity $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    $cart = Cart::query()->find($event->cartID);

    expect($cart->items->first()->quantity)->toEqual(1);

    $this->projector->onDecreaseCartQuantity(
        event: $event,
    );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(ProductWasRemovedFromCart::class);

})->with('RemoveCartQuantity');

it('can apply a coupon to a cart', function (CouponWasApplied $event) {
    expect($this->projector)->toBeInstanceOf(CartProjector::class);

    expect(
        Cart::query()->find($event->cartID)->coupon
    )->toBeNull();

    $this->projector->onCouponWasApplied(
        event: $event,
    );

    expect(
        Cart::query()->find($event->cartID)->coupon
    )->toBeString();


})->with('ApplyCouponToCart');
