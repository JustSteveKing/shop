<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('auth:me');

/**
 * Product Routes
 */
Route::prefix('products')->as('products:')->group(function () {

    /**
     * Show all products
     */
    Route::get(
        '/',
        App\Http\Controllers\Api\V1\Products\IndexController::class,
    )->name('index');

    Route::get(
        '{key}',
        App\Http\Controllers\Api\V1\Products\ShowController::class,
    )->name('show');
});

/**
 * Cart Routes
 */
Route::prefix('carts')->as('carts:')->group(function () {
    /**
     * Get the users cart
     */
    Route::get('/', App\Http\Controllers\Api\V1\Carts\IndexController::class)->name('index');

    /**
     * Create a new cart
     */
    Route::post('/', App\Http\Controllers\Api\V1\Carts\StoreController::class)->name('store');

    /**
     * Add a product to the cart
     */
    Route::post('{cart:uuid}/products', App\Http\Controllers\Api\V1\Carts\Products\StoreController::class)->name('products:store');

    /**
     * Update Quantity
     */
    Route::patch('{cart:uuid}/products/{item:uuid}', App\Http\Controllers\Api\V1\Carts\Products\UpdateController::class)->name('products:update');

    /**
     * Delete Product
     */
    Route::delete('{cart:uuid}/products/{item:uuid}', App\Http\Controllers\Api\V1\Carts\Products\DeleteController::class)->name('products:delete');

    /**
     * Add a coupon to our cart
     */
    Route::post('{cart:uuid}/coupons', App\Http\Controllers\Api\V1\Carts\Coupons\StoreController::class)->name('coupons:store');

    /**
     * Remove a coupon from our cart
     */
    Route::delete('{cart:uuid}/coupons/{uuid}', App\Http\Controllers\Api\V1\Carts\Coupons\DeleteController::class)->name('coupons:delete');
});


/**
 * Order Routes
 */
Route::prefix('orders')->as('orders:')->group(function () {

    /**
     * Turn a Cart into an Order
     */
    Route::post('/', App\Http\Controllers\Api\V1\Orders\StoreController::class)->name('store');
});

/**
 * Wishlist Routes
 */
Route::prefix('wishlists')->as('wishlists:')->group(function () {
    /**
     * Get all wishlists
     */
    Route::get('/', App\Http\Controllers\Api\V1\Wishlists\IndexController::class)->name('index');

    /**
     * Create a new wishlist
     */
    Route::post('/', App\Http\Controllers\Api\V1\Wishlists\StoreController::class)->name('store');

    /**
     * Show a wishlist
     */
    Route::get('{wishlist:uuid}', App\Http\Controllers\Api\V1\Wishlists\ShowController::class)->name('show');

});


/**
 * Stripe Webhooks
 */
Route::middleware(['stripe-webhooks'])->group(function () {
    Route::post(
        'stripe/webhooks',
        \App\Http\Controllers\Api\V1\Orders\StripeWebhookController::class,
    )->name('stripe:webhooks');
});
