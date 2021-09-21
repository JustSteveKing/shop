<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            //
        ];
    }
}
