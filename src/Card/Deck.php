<?php

namespace App\Card;

class Deck
{
    private array $deck;

    public function __construct()
    {
        $this->deck = $this->initializeDeck();
    }

    // Create deck
    private function initializeDeck(): array
    {
        $suits = ['hearts', 'spades', 'diamonds', 'clubs'];
        $values = ['ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'jack', 'queen', 'king'];
        $deck = [];

        // Create all cards in deck
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $card = new CardGraphic($suit, $value);
                $deck[] = $card;
            }
        }

        return $deck;
    }

    public function getDeck(): array
    {
        return $this->deck;
    }

    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    public function drawCard(): ?CardGraphic
    {
        return array_shift($this->deck);
    }

    public function getRemainingCards(): int
    {
        return count($this->deck);
    }
}
