<?php

declare(strict_types=1);

namespace Domains\Customer\Actions;

use Domains\Customer\Models\Cart;
use Domains\Customer\ValueObjects\CartItemValueObject;
use Illuminate\Database\Eloquent\Model;

class AddProductToCart
{
    public static function handle(CartItemValueObject $cartItem, Cart $cart): Model
    {
        return $cart->items()->create($cartItem->toArray());
    }
}
