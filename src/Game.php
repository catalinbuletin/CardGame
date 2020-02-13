<?php

namespace CardGame;

use Illuminate\Support\Collection;

class Game
{
    /**
     * @var Collection|Player[]
     */
    private $players;

    /**
     * @var Deck
     */
    private $deck;

    /**
     * @var int int
     */
    private $turn = 0;

    /**
     * @var int
     */
    private $round = 1;

    /**
     * @var int
     */
    private $maxScore = 50;

    public function __construct(Collection $players)
    {
        $this->players = $players;
        $this->setDeck();
        $this->startGame();
    }

    private function setDeck()
    {
        $this->deck = new Deck($exclude = [2, 3, 4, 5, 6]);
        $this->deck->shuffle();
    }

    private function dealCards()
    {
        while ($this->deck->hasCards()) {
            foreach ($this->players as $player) {
                $player->giveCard($this->deck->dealCardOnTop());
            }
        }

        $this->notifyPlayersDealtCards();
    }

    private function startGame()
    {
        $this->notifyStartOfGame();

        $this->dealCards();

        $this->turn = rand(0, 3);

        while ($this->gameIsRunning()) {
            $this->playRound();

            if ($this->playersAreOutOfCards()) {
                $this->reshuffleDeck();
            }
        }

        $this->notifyEndOfGame();
    }

    private function gameIsRunning() {
        return $this->playerWithHighestScore()->score < $this->maxScore;
    }

    private function playRound()
    {
        $players = $this->getPlayersForRound();

        $round = new GameRound($this->round, $players);
        $round->play();

        $turn = $this->turn;
        $turn++;

        if ($turn > 3) {
            $turn = 0;
        }

        $this->turn = $turn;
        $this->round++;
    }

    private function reshuffleDeck()
    {
        $this->notifyReshuffle();
        $this->setDeck();
        $this->dealCards();
    }

    private function playersAreOutOfCards() {
        return $this->players->first()->countCards() === 0;
    }

    private function getPlayersForRound()
    {
        $players = collect();
        $crt = $this->turn;

        do {
            $players->push($this->players->get($crt));
            $crt++;

            if ($crt > 3) {
                $crt = 0;
            }
        } while ($crt !== $this->turn);


        return $players;
    }

    private function playerWithHighestScore()
    {
        return $this->players->sortByDesc('score')->first();
    }

    private function notifyStartOfGame()
    {
        echo "Starting a game with: " . $this->players->implode('name', ', ') . "\n\n";
    }

    private function notifyPlayersDealtCards()
    {
        foreach ($this->players as $player) {
            echo "{$player->name} has been dealt " . $player->getHand()->implode(', ') . "\n";
        }

        echo "\n\n";
    }

    private function notifyReshuffle()
    {
        echo "Players ran out of cards! Reshuffle. \n\n";
    }

    private function notifyEndOfGame()
    {
        echo "{$this->playerWithHighestScore()->name} looses the game! \n\n";

        foreach ($this->players as $player) {
            echo "{$player->name}: {$player->getScore()} \n";
        }
    }
}
