<?php

use Domains\Customer\Events\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use JustSteveKing\StatusCode\Http;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use function Pest\Laravel\post;

it('can create an order from a cart using the API when not logged in', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);

    $item = CartItem::factory()->create();
    $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data: [
            'cart' => $item->cart->uuid,
            'email' => 'juststevemcd@gmail.com',
            'shipping' => $location->id,
            'billing' => $location->id,
        ],
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(OrderWasCreated::class);
});
