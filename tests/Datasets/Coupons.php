<?php

use Domains\Customer\Models\Coupon;

dataset('coupon', [
    fn() => Coupon::factory()->create()
]);
