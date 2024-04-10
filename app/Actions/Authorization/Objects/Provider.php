<?php

namespace App\Actions\Authorization\Objects;

class Provider
{
    private string $name;

    private string $id;

    public function __construct(string $name, string $id)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
