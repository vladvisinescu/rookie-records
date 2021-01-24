<?php

namespace App\Http\Requests\Addresses;

use Illuminate\Foundation\Http\FormRequest;

class CreateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'postcode' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'town' => 'required',
            'county' => 'required',
            'country' => 'required',
        ];
    }
}
