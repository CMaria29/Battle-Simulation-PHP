<?php
namespace App\GameEngine\skills;
use App\GameEngine\characters\Character;
class MagicArmour implements ISkills
{
    function activateSkills(Character $attacker, Character $defender)
    {
        //  Implement activateSkills() method.
        $message= "Kratos uses Magic Armour! \n";
        $damage = $attacker->getStrength() - $defender->getDefence();
        $reducedDamage = $damage / 2;
        $defender->setHealth($defender->getHealth() - $reducedDamage);
        return $message;
    }



}
