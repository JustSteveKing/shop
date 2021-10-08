<?php

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Coupon;

dataset('cart',[
    fn() => Cart::factory()->create()
]);

dataset('3CartItems',[
    fn() => CartItem::factory()->create(['quantity' => 3])
]);

dataset('CartWith3Items',[
    fn() => Cart::factory()
        ->has(CartItem::factory(['quantity'=>2])->count(3),'items')
        ->create()
]);

dataset('cartItem',[
    fn() => CartItem::factory()->create(['quantity' => 1])
]);

dataset('cartWithCoupon',
    [function () {
        $coupon = Coupon::factory()->create();

        return Cart::factory()->create([
            'coupon' => $coupon->code,
            'reduction' => $coupon->reduction,
        ]);
    }]
);
