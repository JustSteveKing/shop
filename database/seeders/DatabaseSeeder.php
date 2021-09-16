<?php

declare(strict_types=1);

namespace Database\Seeders;

use Domains\Catalog\Models\Category;
use Domains\Catalog\Models\Range;
use Domains\Customer\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Address::factory()->create();
        Category::factory(10)->create();
        Range::factory(10)->create();
    }
}
