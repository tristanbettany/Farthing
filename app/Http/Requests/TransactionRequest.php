<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ];
    }
}
