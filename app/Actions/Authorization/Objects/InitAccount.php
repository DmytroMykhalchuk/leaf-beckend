<?php

namespace App\Actions\Authorization\Objects;

class InitAccount
{
    private string $nickname;

    private string $email;

    private string $locale;

    private object $picture;

    private bool $isEmailNotify;

    private string $country;

    private string $role;

    public function __construct(string $nickname, string $email, string $locale, object $picture, bool $isEmailNotify, string $country, string $role)
    {
        $this->nickname = $nickname;
        $this->email = $email;
        $this->locale = $locale;
        $this->picture = $picture;
        $this->isEmailNotify = $isEmailNotify;
        $this->country = $country;
        $this->role = $role;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getPicture(): object
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
