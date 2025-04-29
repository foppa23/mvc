<?php

namespace App\Card;

class CardGraphic extends Card
{
    public function __construct(string $suit, string $value)
    {
        parent::__construct($suit, $value);
    }

    // Build the filename of the image
    public function getFileName(): string
    {
        return $this->getSuit() . '_' . $this->getValue() . '.svg';
    }

    // Build URL for image
    public function getURL(): string
    {
        return "../../assets/img/" . $this->getFileName();
    }
}
