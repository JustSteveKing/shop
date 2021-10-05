<?php

use Domains\Customer\Models\Location;

dataset('location', [
    fn() => Location::factory()->create()
]);
