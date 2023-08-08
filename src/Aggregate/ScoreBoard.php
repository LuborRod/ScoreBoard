<?php

namespace src\Aggregate;

use SplObjectStorage;
use src\Entity\Game;
use src\Exceptions\GameAlreadyExistsException;

final class ScoreBoard
{
    private SplObjectStorage $games;

    public function __construct()
    {
        $this->games = new SplObjectStorage();
    }

    /**
     * @throws GameAlreadyExistsException
     */
    public function addGame(Game $game): void
    {
        if ($this->gameExists($game)) {
            throw new GameAlreadyExistsException(
                sprintf("The game between %s and %s already exists on the scoreboard.",
                    $game->getHomeTeam()->getName(),
                    $game->getAwayTeam()->getName()
                )
            );
        }

        $this->games->attach($game);
    }

    public function removeGame(Game $game): void
    {
        $this->games->detach($game);
    }

    public function getSummary(): array
    {
        $gamesArray = iterator_to_array($this->games);
        usort($gamesArray, function (Game $a, Game $b) {
            return $b->getScore()->getTotalScore() <=> $a->getScore()->getTotalScore();
        });

        return $gamesArray;
    }

    private function gameExists(Game $game): bool
    {
        return $this->games->contains($game);
    }
}
