<?php

namespace Tests\Aggregate;

use src\Aggregate\ScoreBoard;
use src\Entity\Game;
use src\Entity\Team;
use src\VO\Score;
use src\Exceptions\GameAlreadyExistsException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \src\Aggregate\ScoreBoard
 */
class ScoreBoardTest extends TestCase
{
    private ScoreBoard $scoreBoard;

    protected function setUp(): void
    {
        $this->scoreBoard = new ScoreBoard();
    }

    public function testAddGame(): void
    {
        $team1 = new Team('Team A');
        $team2 = new Team('Team B');
        $game = new Game($team1, $team2);

        $this->scoreBoard->addGame($game);

        $summary = $this->scoreBoard->getSummary();
        $this->assertCount(1, $summary);
        $this->assertSame($game, $summary->first());
    }

    public function testAddGameThrowsExceptionForDuplicateGame(): void
    {
        $team1 = new Team('Team A');
        $team2 = new Team('Team B');
        $game = new Game($team1, $team2);

        $this->scoreBoard->addGame($game);

        $this->expectException(GameAlreadyExistsException::class);

        $this->scoreBoard->addGame($game);
    }

    public function testRemoveGame(): void
    {
        $team1 = new Team('Team A');
        $team2 = new Team('Team B');
        $game = new Game($team1, $team2);

        $this->scoreBoard->addGame($game);
        $this->scoreBoard->removeGame($game);

        $summary = $this->scoreBoard->getSummary();
        $this->assertCount(0, $summary);
    }

    public function testGetSummarySortsGamesByTotalScoreDesc(): void
    {
        $team1 = new Team('Team A');
        $team2 = new Team('Team B');
        $team3 = new Team('Team C');
        $team4 = new Team('Team D');

        $game1 = new Game($team1, $team2);
        $game1->updateScore(new Score(1, 0));

        $game2 = new Game($team3, $team4);
        $game2->updateScore(new Score(2, 2));

        $this->scoreBoard->addGame($game1);
        $this->scoreBoard->addGame($game2);

        $summary = $this->scoreBoard->getSummary();

        $this->assertCount(2, $summary);
        $this->assertSame($game2, $summary->first());
        $this->assertSame($game1, $summary->last());
    }
}

