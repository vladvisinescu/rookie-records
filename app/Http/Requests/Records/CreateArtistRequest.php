<?php

namespace App\Http\Requests\Records;

use Illuminate\Foundation\Http\FormRequest;

class CreateArtistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
