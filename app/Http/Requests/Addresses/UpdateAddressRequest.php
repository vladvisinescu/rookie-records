<?php

namespace App\Http\Requests\Addresses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'postcode' => ['sometimes', 'string'],
            'address_1' => ['sometimes', 'string'],
            'town' => ['sometimes', 'string'],
            'county' => ['sometimes', 'string'],
            'country' => ['sometimes', 'string'],
            'default' => ['sometimes', 'boolean']
        ];
    }
}
