<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Factories\Stripe;

use Domains\Fulfilment\ValueObjects\Stripe\PaymentIntent;
use Stripe\Event;

class PaymentIntentFactory
{
    public static function make(Event $event): PaymentIntent
    {
        return new PaymentIntent(
            id: $event->data->object->id,
            object: $event->data->object->object,
            amount: $event->data->object->amount,
            currency: $event->data->object->currency,
            description: $event->data->object->description,
            status: $event->data->object->status,
        );
    }
}
