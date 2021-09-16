<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraphs(4, true),
            'active' => true,
        ];
    }
}
