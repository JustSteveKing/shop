<?php

use Domains\Catalog\Models\Variant;

dataset('variant', [
    fn() => Variant::factory()->create()
]);
