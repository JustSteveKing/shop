<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Models\Cart;
use Illuminate\Database\Eloquent\Model;

class RemoveProductFromCart
{
    public static function handle(Cart $cart, Model $item): void
    {
        CartAggregate::retrieve(
            uuid: $cart->uuid,
        )->removeProduct(
            purchasableID: $item->id,
            cartID: $cart->id,
            type: $item::class,
        )->persist();
    }
}
