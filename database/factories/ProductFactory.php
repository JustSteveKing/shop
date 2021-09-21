<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Catalog\Models\Category;
use Domains\Catalog\Models\Product;
use Domains\Catalog\Models\Range;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $cost = $this->faker->numberBetween(100, 100000);

        return [
            'name' => $this->faker->words(4, true),
            'description' => $this->faker->paragraphs(2, true),
            'cost' => $cost,
            'retail' => ($cost * config('shop.profit_margin')),
            'active' => $this->faker->boolean(),
            'vat' => config('shop.vat'),
            'category_id' => Category::factory()->create(),
            'range_id' => $this->faker->boolean() ? Range::factory()->create() : null,
        ];
    }
}
