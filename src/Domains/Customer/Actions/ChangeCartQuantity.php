<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;

class ChangeCartQuantity
{
    public static function handle(Cart $cart, CartItem $item, int $quantity = 0): void
    {
        $aggregate = CartAggregate::retrieve(
            uuid: $cart->uuid,
        );

        match (true) {
            $quantity === 0 => $aggregate->removeProduct(
                purchasableID: $item->id,
                cartID:        $cart->id,
                type:          $item::class,
            )->persist(),
            $quantity > $item->quantity => $aggregate->increaseQuantity(
                cartID:     $cart->id,
                cartItemID: $item->id,
                quantity:   $quantity,
            )->persist(),
            $quantity < $item->quantity => $aggregate->decreaseQuantity(
                cartID:     $cart->id,
                cartItemID: $item->id,
                quantity:   $quantity,
            )->persist()
        };
    }
}
