<?php

namespace Tests\Entity;

use src\Entity\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    private Team $team;

    protected function setUp(): void
    {
        $this->team = new Team('Team A');
    }

    public function testGetName(): void
    {
        $this->assertEquals('Team A', $this->team->getName());
    }
}

