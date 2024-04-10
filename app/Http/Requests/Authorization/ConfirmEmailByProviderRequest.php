<?php

namespace App\Http\Requests\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmEmailByProviderRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'provider_id' => 'required|string|max:100',
            'provider_name' => 'required|string|in:google',
        ];
    }

    public function getEmail(): string
    {
        return $this->get('email');
    }

    public function getProviderName(): string
    {
        return $this->get('provider_name');
    }

    public function getProviderId(): string
    {
        return $this->get('provider_id');
    }
}
