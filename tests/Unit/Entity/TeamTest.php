<?php

namespace tests\Entity;

use PHPUnit\Framework\TestCase;
use src\Entity\Team;

final class TeamTest extends TestCase
{
    public function testTeamEquality(): void
    {
        $team1 = new Team('Test');
        $team2 = new Team('Test');
        $team3 = new Team('Other');

        $this->assertTrue($team1->equals($team2));
        $this->assertFalse($team1->equals($team3));
    }

    public function testToString(): void
    {
        $team = new Team('Test');
        $this->assertEquals('Test', (string) $team);
    }
}
