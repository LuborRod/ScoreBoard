<?php

namespace tests\Aggregate;

use PHPUnit\Framework\TestCase;
use src\Aggregate\ScoreBoard;
use src\Entity\Game;
use src\Entity\Team;
use src\VO\Score;
use src\Exceptions\GameAlreadyExistsException;

final class ScoreBoardTest extends TestCase
{
    public function testAddGame(): void
    {
        $scoreboard = new ScoreBoard();
        $game = new Game(new Team('Home'), new Team('Away'));

        $scoreboard->addGame($game);

        $summary = $scoreboard->getSummary();
        $this->assertContains($game, $summary);
    }

    public function testAddGameThrowsExceptionForDuplicate(): void
    {
        $this->expectException(GameAlreadyExistsException::class);

        $scoreboard = new ScoreBoard();
        $game = new Game(new Team('Home'), new Team('Away'));

        $scoreboard->addGame($game);
        $scoreboard->addGame($game);
    }

    public function testRemoveGame(): void
    {
        $scoreboard = new ScoreBoard();
        $game = new Game(new Team('Home'), new Team('Away'));

        $scoreboard->addGame($game);
        $scoreboard->removeGame($game);

        $summary = $scoreboard->getSummary();
        $this->assertNotContains($game, $summary);
    }

    public function testGetSummary(): void
    {
        $scoreboard = new ScoreBoard();
        $game1 = new Game(new Team('Home1'), new Team('Away1'));
        $game1->start();
        $game1->updateScore(new Score(1, 2));

        $game2 = new Game(new Team('Home2'), new Team('Away2'));
        $game2->start();
        $game2->updateScore(new Score(3, 4));

        $scoreboard->addGame($game1);
        $scoreboard->addGame($game2);

        $summary = $scoreboard->getSummary();
        $this->assertSame($game2, $summary[0]);
        $this->assertSame($game1, $summary[1]);
    }
}
