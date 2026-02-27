<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinColocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'join_code' => 'required|string|exists:invitations,token',
        ];
    }

    public function messages(): array
    {
        return [
            'join_code.exists' => 'This invite token is invalid or does not exist.',
        ];
    }
}