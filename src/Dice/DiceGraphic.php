<?php

namespace App\Dice;

class DiceGraphic extends Dice
{
    private $representation = [
        '⚀',                       // utf-8 symboler för tärningarna
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    public function __construct()       // Anropa constructor i parenklassen Dice
    {
        parent::__construct();
    }

    public function getAsString(): string       // Omdefiniera metoden från Dice
    {
        return $this->representation[$this->value - 1];
    }
}
