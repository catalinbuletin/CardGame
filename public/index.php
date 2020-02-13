<?php

use CardGame\Game;
use CardGame\Player;

require __DIR__.'../vendor/autoload.php';

$players = collect([
    new Player('John'),
    new Player('Jane'),
    new Player('Jan'),
    new Player('Otto')
]);

$game = new Game($players);