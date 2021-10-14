<?php

declare(strict_types=1);

namespace Domains\Customer\Projectors;

use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Events\CouponWasApplied;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Coupon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CartProjector extends Projector
{
    public function onProductWasAddedToCart(ProductWasAddedToCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID,
        );

        $item = $cart->items()->create([
            'quantity' => 1,
            'purchasable_id' => $event->purchasableID,
            'purchasable_type' => $event->type,
        ]);

        $cart->update([
            'total' => $item->purchasable->retail,
        ]);
    }

    public function onProductWasRemovedFromCart(ProductWasRemovedFromCart $event): void
    {
        $cart = Cart::query()->find(
            id: $event->cartID,
        );

        $item = CartItem::query()->where(
                column: 'id',
                operator: '=',
                value: $event->purchasableID
            )->where(
                column: 'purchasable_type',
                operator: '=',
                value: $event->type
            )->with(['purchasable'])
            ->first();

        if ($cart->items()->count() === 1) {
            $cart->update([
                'total' => 0,
            ]);
        } else {
            $cart->update([
                'total' => ($cart->total - ($item->quantity * $item->purchasable->retail)),
            ]);
        }

        $cart
            ->items()
            ->where('purchasable_id', $item->purchasable->id)
            ->where('purchasable_type', strtolower(class_basename($item->purchasable)))
            ->delete();
    }

    public function onIncreaseCartQuantity(IncreaseCartQuantity $event): void
    {
        $item = CartItem::query()->where(
            column: 'cart_id',
            operator: '=',
            value: $event->cartID,
        )->where(
            column: 'id',
            operator: '=',
            value: $event->cartItemID,
        )->first();

        $item->update([
            'quantity' => $item->quantity + $event->quantity,
        ]);
    }

    public function onDecreaseCartQuantity(DecreaseCartQuantity $event): void
    {
        $item = CartItem::query()->with(['cart'])->where(
            column: 'cart_id',
            operator: '=',
            value: $event->cartID,
        )->where(
            column: 'id',
            operator: '=',
            value: $event->cartItemID,
        )->first();

        if ($event->quantity >= $item->quantity) {
            CartAggregate::retrieve(
                uuid: $item->cart->uuid,
            )->removeProduct(
                purchasableID: $item->purchasable->id,
                cartID: $item->cart->id,
                type: get_class($item->purchasable),
            )->persist();

            return;
        }

        $item->update([
            'quantity' => ($item->quantity - $event->quantity),
        ]);
    }

    public function onCouponWasApplied(CouponWasApplied $event): void
    {
        $coupon = Coupon::query()->where('code', $event->code)->first();

        Cart::query()->where(
            column:'id',
            operator: '=',
            value: $event->cartID,
        )->update([
            'coupon' => $coupon->code,
            'reduction' => $coupon->reduction,
        ]);
    }
}
