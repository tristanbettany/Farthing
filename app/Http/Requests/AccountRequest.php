<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'sort_code' => 'required',
            'account_number' => 'required',
        ];
    }
}
