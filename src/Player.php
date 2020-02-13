<?php

namespace CardGame;

class Player
{
    public $name;
    public $score = 0;
    private $cards;

    public function __construct($name)
    {
        $this->name = $name;
        $this->cards = collect();
    }

    public function giveCard(Card $card)
    {
        $this->cards->push($card);
    }

    public function countCards()
    {
        return $this->cards->count();
    }

    public function playSmallestCardOrRandom(?Card $playedCard = null)
    {
        $selectedCard = null;

        if ($playedCard) {
            $selectedCard = $this->cards->filter(function (Card $card) use ($playedCard) {
                return $card->isSameSuit($playedCard);
            })->sortBy('value')->first();
        }

        if (!$selectedCard) {
            $selectedCard = $this->cards->random();
        }

        $this->cards = $this->cards->reject(function (Card $card) use ($selectedCard) {
            return $card->equals($selectedCard);
        });

        return $selectedCard;
    }

    public function addScore(int $score)
    {
        $this->score += $score;
    }

    public function getScore() {
        return $this->score;
    }

    public function getHand()
    {
        return $this->cards->map(function (Card $card) {
            return sprintf("%s%s", $card->suit, $card->label);
        });
    }
}
