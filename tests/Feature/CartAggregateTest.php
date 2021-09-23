<?php

declare(strict_types=1);

use Domains\Catalog\Models\Variant;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Models\Cart;

it('can store an event for adding a product', function () {
    $product = Variant::factory()->create();
    $cart = Cart::factory()->create();

    CartAggregate::fake()
        ->given(
            events: new ProductWasAddedToCart(
                purchasableID: $product->id,  //  $product->id + 1 -- makes no difference to the test,
                cartID: $cart->id,
                type: Cart::class,
            )
        )->when(
            callable: function (CartAggregate $aggregate) use ($product, $cart): void {
                $aggregate->addProduct(
                    purchasableID: $product->id,
                    cartID: $cart->id,
                    type: Cart::class,
                );
            },
        )->assertRecorded(
            expectedEvents: new ProductWasAddedToCart(
                purchasableID: $product->id,
                cartID: $cart->id,
                type: Cart::class,
            ),
        );
});
