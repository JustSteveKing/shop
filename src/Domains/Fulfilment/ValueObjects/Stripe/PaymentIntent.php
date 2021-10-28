<?php

declare(strict_types=1);

namespace Domains\Fulfilment\ValueObjects\Stripe;

class PaymentIntent
{
    public function __construct(
        public string $id,
        public string $object,
        public int $amount,
        public string $currency,
        public string $description,
        public string $status,
    ) {}
}
