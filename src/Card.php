<?php

namespace CardGame;

class Card
{
    public $value;
    public $suit;
    public $label;

    public function __construct($value, $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
        $this->label = $this->getLabel($value);
    }

    public function isSameSuit(Card $card)
    {
        return $this->suit === $card->suit;
    }

    public function isSameValue(Card $card)
    {
        return $this->value === $card->value;
    }

    public function equals(Card $card)
    {
        return $this->isSameSuit($card) && $this->isSameValue($card);
    }

    private function getLabel($value)
    {
        $specials = [15 => 'A', 12 => 'J', 13 => 'Q', 14 => 'K'];

        return $specials[$value] ?? $value;
    }
}
