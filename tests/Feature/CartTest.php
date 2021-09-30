<?php

use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\assertDeleted;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

it('creates a cart for an unauthenticated user')
    ->post(
        uri: fn () => route('api:v1:carts:store'),
    )->assertStatus(
        status: Http::CREATED,
    )->assertJson(
        fn (AssertableJson $json) =>
        $json
            ->where('type', 'cart')
            ->where('attributes.status', CartStatus::pending()->label)
            ->etc()
    );

it('returns a cart for a logged in user', function () {
    $cart = Cart::factory()->create();

    auth()->loginUsingId($cart->user_id);

    get(
        uri: route('api:v1:carts:index')
    )->assertStatus(
        status: Http::OK,
    );
});

it('returns a no content status when a guest tries to retrieve their carts')
    ->get(
        uri: fn () => route('api:v1:carts:index'),
    )->assertStatus(
        status: Http::NO_CONTENT,
    );

it('can add a new product to a cart', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);

    $cart = Cart::factory()->create();
    $variant = Variant::factory()->create();

    post(
        uri: route('api:v1:carts:products:store', $cart->uuid),
        data: [
            'quantity' => 1,
            'purchasable_id' => $variant->id,
            'purchasable_type' => 'variant',
        ],
    )->assertStatus(
        status: Http::CREATED,
    );

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(ProductWasAddedToCart::class);
});


it('can increase the quantity of an item in the cart', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);
    $item = CartItem::factory()->create(['quantity' => 1]);

    expect($item->quantity)->toEqual(1);

    patch(
        uri: route('api:v1:carts:products:update', [
            'cart' => $item->cart->uuid,
            'item' => $item->uuid,
        ]),
        data: ['quantity' => 4],
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(IncreaseCartQuantity::class);
});

it('can decrease the quantity of an item in the cart', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);
    $item = CartItem::factory()->create(['quantity' => 3]);

    expect($item->quantity)->toEqual(3);

    patch(
        uri: route('api:v1:carts:products:update', [
               'cart' => $item->cart->uuid,
               'item' => $item->uuid,
           ]),
        data: ['quantity' => 1],
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(DecreaseCartQuantity::class);
});

it('removes an item from the cart when the quantity is zero', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);
    $item = CartItem::factory()->create(['quantity' => 3]);

    expect($item->quantity)->toEqual(3);

    patch(
        uri: route('api:v1:carts:products:update', [
               'cart' => $item->cart->uuid,
               'item' => $item->uuid,
           ]),
        data: ['quantity' => 0],
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(ProductWasRemovedFromCart::class);
});

it('can remove an item from the cart', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);
    $item = CartItem::factory()->create(['quantity' => 3]);

    delete(
        uri: route('api:v1:carts:products:delete', [
            'cart' => $item->cart->uuid,
            'item' => $item->uuid,
        ])
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(ProductWasRemovedFromCart::class);
});
