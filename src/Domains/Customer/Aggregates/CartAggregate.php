<?php

declare(strict_types=1);

namespace Domains\Customer\Aggregates;

use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregate extends AggregateRoot
{
    public function addProduct(int $purchasableID, int $cartID, string $type): self
    {
        $this->recordThat(
            domainEvent: new ProductWasAddedToCart(
                purchasableID: $purchasableID,
                cartID:    $cartID,
                type:      $type,
            ),
        );

        return $this;
    }

    public function removeProduct(int $purchasableID, int $cartID, string $type): self
    {
        $this->recordThat(
            domainEvent: new ProductWasRemovedFromCart(
                purchasableID: $purchasableID,
                cartID: $cartID,
                type: $type,
            ),
        );

        return $this;
    }

    public function increaseQuantity(int $cartID, int $cartItemID, int $quantity): self
    {
        $this->recordThat(
            domainEvent: new IncreaseCartQuantity(
                cartID: $cartID,
                cartItemID: $cartItemID,
                quantity: $quantity,
            ),
        );

        return $this;
    }

    public function decreaseQuantity(int $cartID, int $cartItemID, int $quantity): self
    {
        $this->recordThat(
            domainEvent: new DecreaseCartQuantity(
                cartID: $cartID,
                cartItemID: $cartItemID,
                quantity: $quantity,
            ),
        );

        return $this;
    }
}
