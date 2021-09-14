<?php

declare(strict_types=1);

namespace Database\Seeders;

use Domains\Customer\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Address::factory()->create();
    }
}
