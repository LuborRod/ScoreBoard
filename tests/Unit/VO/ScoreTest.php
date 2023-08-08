<?php

namespace Tests\VO;

use src\VO\Score;
use PHPUnit\Framework\TestCase;

class ScoreTest extends TestCase
{
    public function testGetHome(): void
    {
        $score = new Score(1, 2);
        $this->assertEquals(1, $score->getHome());
    }

    public function testGetAway(): void
    {
        $score = new Score(1, 2);
        $this->assertEquals(2, $score->getAway());
    }

    public function testGetTotalScore(): void
    {
        $score = new Score(1, 2);
        $this->assertEquals(3, $score->getTotalScore());
    }

    public function testIsDrawWithEqualScores(): void
    {
        $score = new Score(2, 2);
        $this->assertTrue($score->isDraw());
    }

    public function testIsDrawWithDifferentScores(): void
    {
        $score = new Score(1, 2);
        $this->assertFalse($score->isDraw());
    }
}