<?php

use function Pest\Laravel\post;

/**
 * @todo Figure out how to test this.
 */
//it('passes the middleware check for a valid signature', function () {
//    $secret = config('services.stripe.endpoint_secret');
//    $time = time();
//    $payload = file_get_contents(__DIR__ . '/../Fixtures/payment-intent.json');
//
//    $timestampedPayload = $time . "." . $payload;
//
//    $signature = hash_hmac('sha256', $timestampedPayload, $secret);
//
//    post(
//        uri: route('api:v1:stripe:webhooks'),
//        data: (array) $payload,
//        headers: [
//            'Stripe-Signature' => "t={$time},v1={$signature}",
//        ],
//    )->assertSuccessful();
//});
