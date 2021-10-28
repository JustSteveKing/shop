<?php

declare(strict_types=1);

namespace App\Http\Middleware\Stripe;

use Closure;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class SignatureValidationMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $event = Webhook::constructEvent(
                payload: $request->getContent(),
                sigHeader: $request->header(
                    key: 'Stripe-Signature',
                ),
                secret: config('services.stripe.endpoint_secret'),
            );
        } catch (UnexpectedValueException $e) {
            abort(Http::UNPROCESSABLE_ENTITY); // Invalid Payload
        } catch (SignatureVerificationException $e) {
            abort(Http::UNAUTHORIZED);
        }

        $request->merge([
            'payload' => $event,
        ]);

        return $next($request);
    }
}
