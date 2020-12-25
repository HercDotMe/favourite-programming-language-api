<?php

namespace App\Entity;

class ProgrammingLanguage
{
    private string $name;

    private int $byteCount;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProgrammingLanguage
    {
        $this->name = $name;

        return $this;
    }

    public function getByteCount(): int
    {
        return $this->byteCount;
    }

    public function setByteCount(int $byteCount): ProgrammingLanguage
    {
        $this->byteCount = $byteCount;

        return $this;
    }
}
