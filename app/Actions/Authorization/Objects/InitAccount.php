<?php

namespace App\Actions\Authorization\Objects;

class InitAccount
{
    private string $nickname;

    private string $email;

    private string $locale;

    private object $picture;

    private bool $isEmailNotify;

    public function __construct(string $nickname, string $email, string $locale, object $picture, bool $isEmailNotify)
    {
        $this->nickname = $nickname;
        $this->email = $email;
        $this->locale = $locale;
        $this->picture = $picture;
        $this->isEmailNotify = $isEmailNotify;
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
}
