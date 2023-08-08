<?php

namespace src\VO;

readonly final class Score
{
    public function __construct(private int $home, private int $away)
    {}

    public function getHome(): int
    {
        return $this->home;
    }

    public function getAway(): int
    {
        return $this->away;
    }

    public function getTotalScore(): int
    {
        return $this->home + $this->away;
    }

    public function isDraw(): bool
    {
        return $this->home === $this->away;
    }
}
