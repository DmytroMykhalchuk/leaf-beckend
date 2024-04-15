<?php

namespace App\Actions\Profile\Objects;

class UpdateProfile
{
    private string $nickname;

    private object|null $picture;

    private bool $isEmailNotify;

    private string $country;

    private string $role;

    public function __construct(string $nickname, object|null $picture, bool $isEmailNotify, string $country, string $role)
    {
        $this->nickname = $nickname;
        $this->picture = $picture;
        $this->isEmailNotify = $isEmailNotify;
        $this->country = $country;
        $this->role = $role;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getPicture(): ?object
    {
        return $this->picture;
    }

    public function getIsEmailNotify(): bool
    {
        return $this->isEmailNotify;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
