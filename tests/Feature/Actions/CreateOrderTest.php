<?php

use Domains\Customer\Actions\CreateOrder;
use Domains\Customer\Models\Order;
use Domains\Customer\Models\OrderLine;
use Domains\Customer\ValueObjects\OrderValueObject;

it('can create an order', function (OrderValueObject $object) {
    expect(Order::query()->count())->toEqual(0);

    CreateOrder::handle(
        object: $object,
    );

    expect(Order::query()->count())->toEqual(1);
    expect(OrderLine::query()->count())->toEqual(1);

})->with('OrderValueObject');
