<?php

namespace App\Http\Requests\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class LoginByGoogleRequest extends FormRequest
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
            'email' => 'required|email',
            'google_id' => 'required|string|max:100',
        ];
    }

    public function getEmail(): string
    {
        return $this->get('email');
    }

    public function getGoogleId(): string
    {
        return $this->get('google_id');
    }
}
