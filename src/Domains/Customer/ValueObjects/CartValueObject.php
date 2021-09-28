<?php

declare(strict_types=1);

namespace Domains\Customer\ValueObjects;

/**
 * @template TKey
 * @template TValue
 */
class CartValueObject
{
    /**
     * @param string $status
     * @param int|null $userId
     */
    public function __construct(
        public string $status,
        public null|int $userId,
    ) {}

    /**
     * @return array<TKey,TValue>
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'user_id' => $this->userId,
        ];
    }
}
