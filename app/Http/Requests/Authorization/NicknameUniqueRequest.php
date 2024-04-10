<?php

namespace App\Http\Requests\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class NicknameUniqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nickname' => 'required|string|max:50',
        ];
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->get('nickname');
    }
}
