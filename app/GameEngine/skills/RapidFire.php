<?php
namespace App\GameEngine\skills;
use App\GameEngine\characters\Character;
class RapidFire implements ISkills
{
    public function activateSkills(Character $attacker, Character $defender)
    {
        $message= "Kratos uses Rapid Fire! \n";
        $attacker->doDamage($defender);
        $attacker->doDamage($defender);
        return $message;

    }

}
