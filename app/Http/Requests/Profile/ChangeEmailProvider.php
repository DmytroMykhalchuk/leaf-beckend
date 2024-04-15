<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangeEmailProvider extends FormRequest
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
            'provider_id'   => 'required|string|max:100',
            'provider_name' => 'required|string|in:google',
            'email'         => 'required|string|email|unique:users,email'
        ];
    }

    public function getProviderId(): string
    {
        return $this->get('provider_id');
    }

    public function getProviderName(): string
    {
        return $this->get('provider_name');
    }

    public function getEmail(): string
    {
        return $this->get('email');
    }
}
