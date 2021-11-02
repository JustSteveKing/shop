<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Wishlists;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'public' => [
                'nullable',
                'boolean'
            ]
        ];
    }
}
