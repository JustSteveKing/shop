<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Wishlists;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\WishlistResource;
use Domains\Customer\Models\Wishlist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $wishlists = QueryBuilder::for(
            subject: Wishlist::class,
        );

        if (auth()->check()) {
            $wishlists->whereHas(
                'owner',
                callback: fn(Builder $builder) => $builder->where('id', auth()->id()),
            );
        } else {
            $wishlists->public();
        }

        return new JsonResponse(
            data: WishlistResource::collection(
                resource: $wishlists->get(),
            ),
            status: Http::OK,
        );

    }
}
