<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'regex' => 'required',
            'hex_code' => 'required',
            'is_light_text' => 'required',
        ];
    }
}
