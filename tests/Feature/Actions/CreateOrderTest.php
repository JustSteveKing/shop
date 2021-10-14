<?php

use Domains\Fulfilment\Actions\CreateOrder;
use Domains\Fulfilment\Models\Order;
use Domains\Fulfilment\Models\OrderLine;
use Domains\Fulfilment\ValueObjects\OrderValueObject;

it('can create an order', function (OrderValueObject $object) {
    expect(Order::query()->count())->toEqual(0);

    CreateOrder::handle(
        object: $object,
    );

    expect(Order::query()->count())->toEqual(1);
    expect(OrderLine::query()->count())->toEqual(1);

})->with('OrderValueObject');
