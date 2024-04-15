<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InitProfileResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nickname' => $this->nickname,
            'email'    => $this->email,
            'picture'  => $this->picture,
            'role'     => $this->role,
            'country'  => $this->country,
        ];
    }
}
