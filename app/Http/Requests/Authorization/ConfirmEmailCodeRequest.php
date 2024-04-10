<?php

namespace App\Http\Requests\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmEmailCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'int|max:99999',
            'email' => 'email|exists:users,email',
        ];
    }

    public function getEmail(): string
    {
        return $this->get('email');
    }

    public function getCode(): int
    {
        return $this->get('code');
    }
}
