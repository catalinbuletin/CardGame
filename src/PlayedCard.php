<?php

namespace CardGame;

class PlayedCard
{
    public $card;
    public $player;

    public function __construct(Card $card, Player $player)
    {
        $this->card = $card;
        $this->player = $player;
    }
}
