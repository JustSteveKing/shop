<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Wishlists;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\WishlistResource;
use Domains\Customer\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class ShowController extends Controller
{
    public function __invoke(Request $request, Wishlist $wishlist): JsonResponse
    {
        if(! $wishlist->public) {
            if (auth()->guest() || auth()-id() !== $wishlist->user_id) {
                abort(Http::FORBIDDEN);
            }
        }

        return new JsonResponse(
            data: new WishlistResource(
                resource: $wishlist,
            ),
            status: Http::OK,
        );
    }
}
