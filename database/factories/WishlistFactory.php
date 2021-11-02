<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\User;
use Domains\Customer\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistFactory extends Factory
{
    protected $model = Wishlist::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'public' => $this->faker->boolean(),
            'user_id' => User::factory()->create(),
        ];
    }
}
