<?php

namespace App\Entity;

class Repository
{
    private int $id;

    private string $name;

    private string $fullName;

    private string $url;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Repository
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Repository
    {
        $this->name = $name;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): Repository
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): Repository
    {
        $this->url = $url;

        return $this;
    }
}
