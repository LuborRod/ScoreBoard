<?php

namespace Tests\Entity;

use src\Entity\Game;
use src\Entity\Team;
use src\Exceptions\GameAlreadyFinishedException;
use src\Exceptions\GameAlreadyStartedException;
use src\VO\Score;
use src\Exceptions\GameNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \src\Entity\Game
 */
class GameTest extends TestCase
{
    private Game $game;
    private Team $teamA;
    private Team $teamB;

    protected function setUp(): void
    {
        $this->teamA = new Team('Team A');
        $this->teamB = new Team('Team B');
        $this->game = new Game($this->teamA, $this->teamB);
    }

    public function testStart(): void
    {
        $this->game->start();
        $this->assertTrue($this->game->isStarted());
        $this->assertFalse($this->game->isFinished());
    }

    public function testFinish(): void
    {
        $this->game->start();
        $this->game->finish();
        $this->assertTrue($this->game->isFinished());
    }

    public function testUpdateScoreWhenGameNotStarted(): void
    {
        $this->expectException(GameNotFoundException::class);
        $score = new Score(1, 2);
        $this->game->updateScore($score);
    }

    public function testUpdateScoreWhenGameFinished(): void
    {
        $this->game->start();
        $this->game->finish();
        $this->expectException(GameNotFoundException::class);
        $score = new Score(1, 2);
        $this->game->updateScore($score);
    }

    public function testUpdateScore(): void
    {
        $this->game->start();
        $score = new Score(1, 2);
        $this->game->updateScore($score);
        $this->assertSame($score, $this->game->getScore());
    }

    public function testGetHomeTeam(): void
    {
        $this->assertSame($this->teamA, $this->game->getHomeTeam());
    }

    public function testGetAwayTeam(): void
    {
        $this->assertSame($this->teamB, $this->game->getAwayTeam());
    }

    public function testGameCannotStartTwice(): void
    {
        $this->expectException(GameAlreadyStartedException::class);

        $game = new Game(new Team('Home'), new Team('Away'));
        $game->start();
        $game->start();
    }

    public function testGameCannotFinishTwice(): void
    {
        $this->expectException(GameAlreadyFinishedException::class);

        $game = new Game(new Team('Home'), new Team('Away'));
        $game->finish();
        $game->finish();
    }

    public function testGameCannotUpdateScoreAfterFinish(): void
    {
        $this->expectException(GameAlreadyFinishedException::class);

        $game = new Game(new Team('Home'), new Team('Away'));
        $game->start();
        $game->finish();
        $game->updateScore(new Score(3, 4));
    }
}

