<?php

namespace src\Entity;

use src\Exceptions\GameNotFoundException;
use src\VO\Score;

final class Game
{
    private Team $homeTeam;
    private Team $awayTeam;
    private Score $score;
    private bool $started;
    private bool $finished;

    public function __construct(Team $homeTeam, Team $awayTeam)
    {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->score = new Score(0, 0);
        $this->started = false;
        $this->finished = false;
    }

    public function start(): void {
        $this->started = true;
    }

    public function finish(): void {
        $this->finished = true;
    }

    /**
     * @throws GameNotFoundException
     */
    public function updateScore(Score $score): void
    {
        if (!$this->started || $this->finished) {
            throw new GameNotFoundException("Can't update score of a game that hasn't started or is already finished.");
        }
        $this->score = $score;
    }

    public function getScore(): Score
    {
        return $this->score;
    }

    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    public function isStarted(): bool
    {
        return $this->started;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }
}
