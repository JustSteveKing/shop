<?php

declare(strict_types=1);

use Domains\Catalog\Models\Variant;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Models\Cart;

it('can store an event for adding a product', function () {
    $product = Variant::factory()->create();
    $cart = Cart::factory()->create();

    $event = new ProductWasAddedToCart(
        purchasableID: $product->id,
        cartID: $cart->id,
        type: Cart::class,
    );

    CartAggregate::fake()
        ->given(
            events: [
                $event
            ]
        )->when(
            callable: function (CartAggregate $aggregate) use ($product, $cart): void {
                $aggregate->addProduct(
                    purchasableID: $product->id,
                    cartID:        $cart->id,
                    type:          Cart::class,
                );
            },
        )->assertEventRecorded(
            expectedEvent: $event,
        );
});

