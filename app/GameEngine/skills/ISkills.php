<?php
namespace App\GameEngine\skills;
use App\GameEngine\characters\Character;
interface ISkills
{
    function activateSkills(Character $attacker, Character $defender);

}
