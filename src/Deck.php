<?php

namespace CardGame;

class Deck
{
    protected $cards;

    public function __construct($exclude = [])
    {
        $this->cards = $this->deckCards()->filter(function (Card $card) use ($exclude) {
            return !in_array($card->value, $exclude);
        });
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function countCards()
    {
        return $this->cards->count();
    }

    public function shuffle()
    {
        $this->cards = $this->cards->shuffle();
    }

    public function hasCards()
    {
        return $this->cards->isNotEmpty();
    }

    public function dealCardOnTop(): Card
    {
        return $this->cards->shift();
    }

    private function deckCards()
    {
        return collect([
            new Card(2, '♥'),
            new Card(2, '♠'),
            new Card(2, '♦'),
            new Card(2, '♣'),
            new Card(3, '♥'),
            new Card(3, '♠'),
            new Card(3, '♦'),
            new Card(3, '♣'),
            new Card(4, '♥'),
            new Card(4, '♠'),
            new Card(4, '♦'),
            new Card(4, '♣'),
            new Card(5, '♥'),
            new Card(5, '♠'),
            new Card(5, '♦'),
            new Card(5, '♣'),
            new Card(6, '♥'),
            new Card(6, '♠'),
            new Card(6, '♦'),
            new Card(6, '♣'),
            new Card(7, '♥'),
            new Card(7, '♠'),
            new Card(7, '♦'),
            new Card(7, '♣'),
            new Card(8, '♥'),
            new Card(8, '♠'),
            new Card(8, '♦'),
            new Card(8, '♣'),
            new Card(9, '♥'),
            new Card(9, '♠'),
            new Card(9, '♦'),
            new Card(9, '♣'),
            new Card(10, '♥'),
            new Card(10, '♠'),
            new Card(10, '♦'),
            new Card(10, '♣'),
            new Card(12, '♥'),
            new Card(12, '♠'),
            new Card(12, '♦'),
            new Card(12, '♣'),
            new Card(13, '♥'),
            new Card(13, '♠'),
            new Card(13, '♦'),
            new Card(13, '♣'),
            new Card(14, '♥'),
            new Card(14, '♠'),
            new Card(14, '♦'),
            new Card(14, '♣'),
            new Card(15, '♥'),
            new Card(15, '♠'),
            new Card(15, '♦'),
            new Card(15, '♣'),
        ]);
    }
}

