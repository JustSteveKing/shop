<?php

declare(strict_types=1);

use Domains\Customer\Events\CouponWasApplied;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;

use JustSteveKing\StatusCode\Http;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\post;
use function Pest\Laravel\delete;

it('can remove a coupon from the cart', function (Cart $cartWithCoupon): void {

    expect($cartWithCoupon->refresh())->coupon->toBeString();

    $coupon = Coupon::query()->where('code', $cartWithCoupon->coupon)->first();

    delete(
        uri: route('api:v1:carts:coupons:delete', [
            'cart' => $cartWithCoupon->uuid,
            'uuid' => $coupon->uuid,
        ]),
    )->assertStatus(Http::ACCEPTED);

    expect($cartWithCoupon->refresh())->coupon->toBeNull();
})->with('cartWithCoupon');

it('can apply a coupon to the cart', function (Cart $cart, Coupon $coupon) {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);

    expect($cart)
        ->reduction
        ->toEqual(0);

    post(
        uri: route('api:v1:carts:coupons:store', $cart->uuid),
        data: ['code' => $coupon->code,]
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(CouponWasApplied::class);
})->with('cart','coupon');
