<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => 'category',
            'attributes' => [
                'key' => $this->key,
                'name' => $this->name,
                'description' => $this->description,
                'active' => $this->active,
            ],
            'relationships' => [
                'products' => ProductResource::collection(
                    resource: $this->whenLoaded(
                        relationship: 'products',
                    ),
                ),
            ]
        ];
    }
}
