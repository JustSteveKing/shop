<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductResource;
use Domains\Catalog\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

class IndexController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $products = QueryBuilder::for(
            subject: Product::class,
        )->allowedIncludes(
            includes: ['category', 'range', 'variants'],
        )->allowedFilters(
            filters: ['active', 'vat'],
        )->paginate();

        return response()->json(
            data: ProductResource::collection(
                resource: $products,
            ),
            status: Http::OK,
        );
    }
}
