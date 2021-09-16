<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Catalog\Models\Product;
use Domains\Catalog\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantFactory extends Factory
{
    protected $model = Variant::class;

    public function definition(): array
    {
        $product = Product::factory()->create();
        $cost = $this->faker->boolean ? $product->cost : ($product->cost + $this->faker->numberBetween(100, 7500));
        $shippable = $this->faker->boolean;

        return [
            'name' => $this->faker->words(3, true),
            'cost' => $cost,
            'retail' => ($product->cost === $cost) ? $product->retail : ($product->retail + $this->faker->numberBetween(100, 7500)),
            'height' => $shippable ? $this->faker->numberBetween(100, 10000) : null,
            'width' => $shippable ? $this->faker->numberBetween(100, 10000) : null,
            'length' => $shippable ? $this->faker->numberBetween(100, 10000) : null,
            'weight' => $shippable ? $this->faker->numberBetween(100, 10000) : null,
            'active' => $this->faker->boolean,
            'shippable' => $shippable,
            'product_id' => $product->id,
        ];
    }
}
