<?php

namespace CardGame;

use Illuminate\Support\Collection;

class GameRound
{
    private $round;
    private $players;
    private $suit;
    private $playedCards;
    private $looserCard;
    private $looserHand;
    private $looserScore;

    public function __construct(int $round, Collection $players)
    {
        $this->round = $round;
        $this->players = $players;
        $this->playedCards = collect();
    }

    public function play()
    {
        $this->notifyStartOfRound();
        $this->playCards();
        $this->determineLooser();
        $this->calculateScore();
        $this->notifyEndOfRound();
    }

    private function playCards() {
        $firstCard = null;

        foreach ($this->players as $player) {
            if ($firstCard === null) {
                $firstCard = $player->playSmallestCardOrRandom();
                $this->suit = $firstCard->suit;

                $this->playedCards->push(
                    new PlayedCard($firstCard, $player)
                );
            } else {
                $this->playedCards->push(
                    new PlayedCard($player->playSmallestCardOrRandom($firstCard), $player)
                );
            }
        }
        $this->notifyPlayedCards();
    }

    private function determineLooser()
    {
        $biggestPlayedCardOfSuit = $this->playedCards
            ->where('card.suit', $this->suit)
            ->sortByDesc('card.value')
            ->first();

        $this->looserCard = $biggestPlayedCardOfSuit;
        $this->looserHand = $this->playedCards->map->card;
    }

    private function calculateScore()
    {
        $score = 0;

        foreach ($this->looserHand as $card) {
            if ($card->suit === '♥') {
                $score += 1;
            }

            if ($card->value === 12 && $card->suit === '♣') {
                $score += 2;
            }

            if ($card->value === 13 && $card->suit === '♠') {
                $score += 5;
            }
        }

        $this->looserScore = $score;
        $this->looserCard->player->addScore($score);
    }

    private function notifyStartOfRound()
    {
        echo "Round {$this->round}: {$this->players->first()->name} starts the round. \n\n";
    }

    private function notifyPlayedCards()
    {
        foreach ($this->playedCards as $playedCard) {
            $playerName = $playedCard->player->name;
            $playedCard = sprintf("%s%s", $playedCard->card->suit, $playedCard->card->label);

            echo "{$playerName} plays {$playedCard} \n";
        }

        echo "\n\n";
    }

    private function notifyEndOfRound()
    {
        $looser = $this->looserCard->player;
        $looserCard = sprintf("%s%s", $this->looserCard->card->suit, $this->looserCard->card->label);

        echo "{$looser->name} played {$looserCard}, the highest matching card of this round and got {$this->looserScore} points added to his total score. {$looser->name}’s total score is {$looser->getScore()} point. \n\n";
    }
}
