<?php

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;

dataset('cart',[
    fn() => Cart::factory()->create()
]);

dataset('3CartItems',[
    fn() => CartItem::factory()->create(['quantity' => 3])
]);

dataset('cartItem',[
    fn() => CartItem::factory()->create(['quantity' => 1])
]);
