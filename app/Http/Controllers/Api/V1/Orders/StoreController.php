<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Orders\StoreRequest;
use Domains\Fulfilment\Aggregates\OrderAggregate;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): Response
    {
        OrderAggregate::retrieve(
            uuid: Str::uuid()->toString(),
        )->createOrder(
            cart:     $request->get('cart'),
            shipping: $request->get('shipping'),
            billing:  $request->get('billing'),
            user:     auth()->check() ? auth()->id() : null,
            email:    auth()->guest() ? $request->get('email') : null,
        )->persist();

        return new Response(
            content: null,
            status: Http::ACCEPTED,
        );
    }
}
