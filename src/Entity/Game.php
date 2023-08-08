<?php

namespace src\Entity;

use src\Exceptions\GameAlreadyFinishedException;
use src\Exceptions\GameAlreadyStartedException;
use src\VO\Score;

final class Game
{
    private Score $score;
    private bool $started;
    private bool $finished;

    public function __construct(private readonly Team $homeTeam, private readonly Team $awayTeam)
    {
        $this->score = new Score(0, 0);
        $this->started = false;
        $this->finished = false;
    }

    /**
     * @throws GameAlreadyStartedException
     */
    public function start(): void {
        $this->validateStart();
        $this->started = true;
    }

    /**
     * @throws GameAlreadyFinishedException
     */
    public function finish(): void {
        $this->validateFinish();
        $this->finished = true;
    }


    /**
     * @throws GameAlreadyStartedException
     * @throws GameAlreadyFinishedException
     */
    public function updateScore(Score $score): void
    {
        //TODO The next step we can validate data in Score (we can't decrease score -> only increase).
        $this->validateStart();
        $this->validateFinish();
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

    public function equals(Game $game): bool
    {
        return $this->homeTeam->equals($game->getHomeTeam()) && $this->awayTeam->equals($game->getAwayTeam());
    }

    /**
     * @throws GameAlreadyStartedException
     */
    private function validateStart(): void
    {
        if ($this->started) {
            throw new GameAlreadyStartedException("The game has already started.");
        }
    }

    /**
     * @throws GameAlreadyFinishedException
     */
    private function validateFinish(): void
    {
        if ($this->started) {
            throw new GameAlreadyFinishedException("The game has already finished.");
        }
    }
}
