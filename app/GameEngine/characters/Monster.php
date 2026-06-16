<?php

namespace App\GameEngine\characters;

class Monster extends Character
{
    private string $name = "Monster";

    public function getName(): string
    {
        return $this->name;
    }


    public function attack(Character $defender): ?string
    {
        $defenceMessage = $defender->defence($this);

        if ($defenceMessage) {
            // Dacă apărătorul s-a apărat cu succes, returnăm mesajul lui
            return $defenceMessage;
        }

        $damage = $this->doDamage($defender);
        return "Monster strikes, dealing $damage damage.";
    }

    // Schimbăm din bool în ?string
    public function defence(Character $attacker): ?string
    {
        if (rand(1, 100) <= $this->getLuck()) {
            // Fără echo! Returnăm textul.
            return "Monster is lucky! No damage received this round.";
        }

        return null; // Nu s-a apărat prin noroc
    }
}
