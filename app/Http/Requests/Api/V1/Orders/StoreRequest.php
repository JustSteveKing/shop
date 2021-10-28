<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Orders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart' => [
                'required',
                'string',
                'exists:carts,uuid',
            ],
            'email' => [
                Rule::requiredIf(auth()->guest()),
                'email:rfc,dns',
            ],
            'shipping' => [
                'required',
                'int',
                'exists:locations,id',
            ],
            'billing' => [
                'required',
                'int',
                'exists:locations,id',
            ],
            'intent' => [
                'required',
                'string',
            ]
        ];
    }
}
