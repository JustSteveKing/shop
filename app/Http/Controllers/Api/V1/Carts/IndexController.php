<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Carts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CartResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JustSteveKing\StatusCode\Http;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class IndexController extends Controller
{
    public function __invoke(Request $request): SymfonyResponse
    {
        if (! auth()->check() || ! auth()->user()->cart()->count()) {
            return new Response(
                content: null,
                status: Http::NO_CONTENT,
            );
        }

        return new JsonResponse(
            data: new CartResource(
                resource: auth()->user()->cart,
            ),
            status: Http::OK,
        );
    }
}
