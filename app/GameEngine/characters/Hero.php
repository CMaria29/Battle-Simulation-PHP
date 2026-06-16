<?php
namespace App\GameEngine\characters; // Atenție la litera mare la Characters (standard PSR-4)

use App\GameEngine\skills\RapidFire;
use App\GameEngine\skills\MagicArmour;

class Hero extends Character
{
    private $name = "Kratos";
    public $skills = [];

    public function __construct($strength, $health, $defence, $luck, $speed)
    {
        parent::__construct($strength, $health, $defence, $luck, $speed);
        // Autoloading-ul se ocupă de restul, nu mai e nevoie de require
        $this->skills['rapidFire'] = new RapidFire();
        $this->skills['magicArmour'] = new MagicArmour();
    }

    public function getName()
    {
        return $this->name;
    }

    public function attack(Character $defender)
    {
        $log = "";

        // Verificăm apărarea inamicului
        $defenceStatus = $defender->defence($this);

        if($defenceStatus) {
            return $defenceStatus; // Returnăm mesajul de apărare (ex: "Monster was lucky")
        }

        // Dacă nu s-a apărat, atacăm
        if (rand(1, 100) <= 15) {

            return "Kratos activates RapidFire! " . $this->skills['rapidFire']->activateSkills($this, $defender);
        }

        $damage = $this->doDamage($defender);
        return "Kratos strikes, dealing $damage damage.";
    }

    public function defence(Character $attacker)
    {
        if (rand(1, 100) <= $this->getLuck()) {
            return "Kratos is lucky! No damage received this round.";
        }

        if (rand(1, 100) <= 15) {
            $skillEffect = $this->skills['magicArmour']->activateSkills($attacker, $this);
            return "Kratos activates Magic Armour! " . $skillEffect;
        }

        return null; // Nu s-a activat nicio apărare specială
    }
}
