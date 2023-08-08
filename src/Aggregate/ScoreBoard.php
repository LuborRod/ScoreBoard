<?php

namespace src\Aggregate;

use Illuminate\Support\Collection;
use src\Entity\Game;
use src\Exceptions\GameAlreadyExistsException;

final class ScoreBoard
{
    private Collection $games;

    public function __construct()
    {
        $this->games = new Collection();
    }

    /**
     * @throws GameAlreadyExistsException
     */
    public function addGame(Game $game): void
    {
        if ($this->gameExists($game)) {
            throw new GameAlreadyExistsException(
                "The game between {$game->getHomeTeam()->getName()} and {$game->getAwayTeam()->getName()} already exists on the scoreboard."
            );
        }

        $this->games->push($game);
    }


    public function removeGame(Game $game): void
    {
        $this->games = $this->games->reject(function ($g) use ($game) {
            return $g === $game;
        });
    }

    public function getSummary(): Collection
    {
        return $this->games->sortByDesc(function (Game $game) {
            return $game->getScore()->getTotalScore();
        });
    }

    private function gameExists(Game $game): bool
    {
        return $this->games->contains(function ($g) use ($game) {
            return $g->getHomeTeam() === $game->getHomeTeam() && $g->getAwayTeam() === $game->getAwayTeam();
        });
    }
}

