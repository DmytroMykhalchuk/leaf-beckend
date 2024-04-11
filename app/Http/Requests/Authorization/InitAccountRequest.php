<?php

namespace App\Http\Requests\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class InitAccountRequest extends FormRequest
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
            'nickname'        => 'required|string|min:1|max:50',
            'email'           => 'required|string',
            'locale'          => 'nullable|string',
            'picture'         => 'required|mimes:jpeg,jpg,png|max:5120',
            'is_email_notify' => 'required|boolean',
            'provider'        => 'nullable|array',
            'provider.name'   => 'nullable|string|in:google',
            'provider.id'     => 'nullable|string|max:100',
            'country'         => 'required|string|max:100',
            'role'            => 'required|string|in:coach,student',
        ];
    }

    public function getNickname(): string
    {
        return $this->get('nickname');
    }

    public function getEmail(): string
    {
        return $this->get('email');
    }

    public function getLocale(): string
    {
        return $this->get('locale') ?? 'uk';
    }

    public function getPicture(): object
    {
        return $this->file('picture');
    }

    public function getIsEmailNotify(): bool
    {
        return $this->get('is_email_notify');
    }

    public function getProviderName(): string
    {
        return $this->get('provider', [])['name'] ?? '';
    }

    public function getProviderId(): string
    {
        return $this->get('provider', [])['id'] ?? '';
    }

    public function getCountry(): string
    {
        return $this->get('country');
    }

    public function getRole(): string
    {
        return $this->get('role');
    }
}
