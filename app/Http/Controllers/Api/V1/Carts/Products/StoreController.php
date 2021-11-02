<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Carts\ProductRequest;
use App\Http\Resources\Api\V1\CartItemResource;
use Domains\Customer\Actions\AddProductToCart;
use Domains\Customer\Aggregates\CartAggregate;
use Domains\Customer\Factories\CartItemFactory;
use Domains\Customer\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(ProductRequest $request, Cart $cart): Response
    {
        CartAggregate::retrieve(
            uuid: $cart->uuid,
        )->addProduct(
            purchasableID: $request->get('purchasable_id'),
            cartID:        $cart->id,
            type:          $request->get('purchasable_type'),
        )->persist();

        return new Response(
            content: null,
            status: Http::CREATED,
        );
    }
}
