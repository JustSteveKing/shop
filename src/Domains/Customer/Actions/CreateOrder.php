<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Order;
use Domains\Customer\States\Statuses\OrderStatus;
use Domains\Customer\ValueObjects\OrderValueObject;

class CreateOrder
{
    public static function handle(OrderValueObject $object): void
    {
        $cart = Cart::query()
            ->with(['items'])
            ->where('uuid', $object->cart)
            ->first();

        $order = Order::query()->create([
            'number' => 'random-order-number',
            'state' => OrderStatus::pending()->label,
            'coupon' => $cart->coupon,
            'total' => 'calculate me',
            'reduction' => $cart->reduction,
            'user_id' => is_null($object->email) ? $object->user : null,
            'shipping_id' => $object->shipping,
            'billing_id' => $object->billing,
        ]);

        // order items
        // payment
    }
}
