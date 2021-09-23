<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CartProjector extends Projector
{
    public function onProductWasAddedToCart(ProductWasAddedToCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID,
        );

        $cart->items()->create([
            'purchasable_id' => $event->productID,
            'purchasable_type' => $event->type,
        ]);
    }

    public function onProductWasRemovedFromCart(ProductWasRemovedFromCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID,
        );

        $cart->items()
            ->where('puchasable_id', $event->purchasableID)
            ->where('puchasable_type', $event->type)
            ->delete();
    }

    public function onIncreaseCartQuantity(IncreaseCartQuantity $event): void
    {
        $item = CartItem::query()->where(
            column: 'cart_id',
            value: $event->cartID,
        )->where(
            column: 'id',
            value: $event->cartItemID,
        )->first();

        $item->update([
            'quantity' => ($item->quantity + $event->quantity),
        ]);
    }

    public function onDecreaseCartQuantity(DecreaseCartQuantity $event): void
    {
        $item = CartItem::query()->where(
            column: 'cart_id',
            value: $event->cartID,
        )->where(
            column: 'id',
            value: $event->cartItemID,
        )->first();

        if ($event->quantity >= $item->quantity) {
            CartAggregate::retrieve(
                uuid: Str::uuid()->toString(),
            )->removeProduct(
                purchasableID: $item->purchasable->id,
                cartID: $item->cart_id,
                type: get_class($item->purchasable),
            );

            return;
        }

        $item->update([
            'quantity' => ($item->quantity - $event->quantity),
        ]);
    }
}
