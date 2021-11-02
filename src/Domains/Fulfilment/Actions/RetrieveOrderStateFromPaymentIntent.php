<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Actions;

use Domains\Fulfilment\States\Statuses\OrderStatus;
use Domains\Fulfilment\ValueObjects\Stripe\PaymentIntent;
use Spatie\Enum\Enum;

class RetrieveOrderStateFromPaymentIntent
{
    public static function handle(PaymentIntent $object): Enum
    {
        return match ($object->status) {
            'succeeded' => OrderStatus::completed(),
            'failed' => OrderStatus::delined(),
            'refunded' => OrderStatus::refunded(),
            default => OrderStatus::pending(),
        };
    }
}
