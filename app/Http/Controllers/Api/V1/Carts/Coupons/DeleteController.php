<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Coupons;

use App\Http\Controllers\Controller;
use Domains\Customer\Actions\RemoveCouponFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class DeleteController extends Controller
{
    public function __invoke(Request $request, Cart $cart, string $uuid)
    {
        $coupon = Coupon::query()->where('uuid', $uuid)->firstOrFail();

        if ($cart->coupon !== $coupon->code) {
            abort(
                code: Http::NOT_FOUND,
            );
        }

        RemoveCouponFromCart::handle(
            cart: $cart,
        );

        return new Response(
            content: null,
            status: Http::ACCEPTED,
        );
    }
}
