<?php

namespace src\Entity;

final readonly class Team
{
    public function __construct(private string $name)
    {}

    public function getName(): string
    {
        return $this->name;
    }

    public function equals(Team $team): bool
    {
        return $this->name === $team->getName();
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
