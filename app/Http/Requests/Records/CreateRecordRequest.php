<?php

namespace App\Http\Requests\Records;

use Illuminate\Foundation\Http\FormRequest;

class CreateRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'record_id' => 'required',
            ''
        ];
    }
}
