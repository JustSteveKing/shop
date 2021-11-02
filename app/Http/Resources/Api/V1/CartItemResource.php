<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'type' => 'cart-item',
            'attributes' => [
                'id' => $this->uuid,
                'quantity' => $this->quantity,
                'item' => [
                    'id' => $this->purchasable_id,
                    'type' => $this->purchasable_type,
                ]
            ],
            'relationships' => [
                'cart' => new CartResource(
                    resource: $this->whenLoaded(
                        relationship: 'cart',
                    ),
                )
            ]
        ];
    }
}
