<?php

namespace App\Http\Requests\Records;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'string',
            'price' => ['required', 'numeric', 'min:1'],
            'grading' => 'required',
            'year' => ['required', 'numeric'],
            'discogs_id' => 'required',
            'category_id' => 'required',
            'artists' => ['required', 'array', 'min:1'],
            'labels' => ['required', 'array', 'min:1'],
            'genres' => ['required', 'array', 'min:1']
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Required'
        ];
    }
}
