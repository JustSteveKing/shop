<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\Products\UpdateRequest;
use Domains\Customer\Actions\ChangeCartQuantity;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Cart $cart, CartItem $item): Response
    {
        ChangeCartQuantity::handle(
            cart: $cart,
            item: $item,
            quantity: $request->get('quantity'),
        );

        return new Response(
            content: null,
            status: Http::ACCEPTED,
        );
    }
}
