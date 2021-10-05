<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use Domains\Customer\Models\User;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        return [
            'status' => Arr::random(
                array: CartStatus::toLabels(),
            ),
            'coupon' => null,
            'total' => $this->faker->numberBetween(10000, 100000),
            'reduction' => 0,
            'user_id' => User::factory()->create(),
        ];
    }
}
