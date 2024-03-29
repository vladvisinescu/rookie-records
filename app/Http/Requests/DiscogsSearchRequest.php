<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscogsSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'term' => 'required|string',
        ];
    }
}
