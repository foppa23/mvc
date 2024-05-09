<?php

namespace App\Dice;

class Dice
{
    protected $value;                       // Ev protected ?int $value;  då det kan vara null

    public function __construct()
    {
        $this->value = null;
    }

    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    public function getValue(): int         // Ev ?int eftersom det kan vara null
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
