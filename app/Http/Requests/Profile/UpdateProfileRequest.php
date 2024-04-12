<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'picture'         => 'nullable|mimes:jpeg,jpg,png|max:5120',
            'is_email_notify' => 'required|boolean',
            'country'         => 'required|string|max:100',
            'role'            => 'required|string|in:coach,student',
        ];
    }

    public function getNickname(): string
    {
        return $this->get('nickname');
    }

    public function getPicture(): null|object
    {
        return $this->file('picture');
    }

    public function getIsEmailNotify(): bool
    {
        return $this->get('is_email_notify');
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
