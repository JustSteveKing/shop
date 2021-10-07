<?php

use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;

dataset('AddedToCart', [
    fn() => new ProductWasAddedToCart(
        purchasableID: Variant::factory()->create()->id,
        cartID: Cart::factory()->create(['total' => 0])->id,
        type: 'variant',
    ),
]);

dataset('RemovedFromCart', [
    fn() => new ProductWasRemovedFromCart(
        purchasableID: Variant::factory()->create()->id,
        cartID:        CartItem::factory()->create()->cart_id,
        type:          'variant',
    )
]);

dataset('IncreaseCartQuantity', [
    fn() => new IncreaseCartQuantity(
        cartID: ($cart = Cart::factory()->create())->id,
        cartItemID: CartItem::factory()->create(['cart_id'=> $cart->id, 'quantity' => 1])->id,
        quantity: 1,
    ),
]);
