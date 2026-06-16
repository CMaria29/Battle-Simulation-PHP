<?php
namespace App\GameEngine\characters;
abstract class Character
{
    protected $health;
    protected $strength;
    protected $speed;
    protected $defence;
    protected $luck;
    public function __construct($strength, $health, $defence, $luck, $speed) {
        $this->strength = $strength;
        $this->health = $health;
        $this->defence = $defence;
        $this->luck = $luck;
        $this->speed = $speed;
    }

    function getHealth()
    {
        // TODO: Implement getHealth() method.
        return $this->health;
    }
    function setHealth($health)
    {
        $this->health = $health;
    }

    function getSpeed()
    {
        // TODO: Implement getSpeed() method.
        return $this->speed;
    }

    function getDefence()
    {
        // TODO: Implement getDefence() method.
        return $this->defence;
    }


    function getLuck()
    {
        // TODO: Implement getLuck() method.
        return $this->luck;
    }

    function getStrength()
    {
        // TODO: Implement getStrength() method.
        return $this->strength;
    }

    function getDamage(Character $defender)
    {   $damage = $this->strength - $defender->getDefence();
        $damage = max(0, $damage);
        return $damage;
    }
    function doDamage(Character $defender)
    {
        $damage = $this->getDamage($defender);

        $newHealth = $defender->getHealth() - $damage;
        $defender->setHealth(max(0, $newHealth));
        return "Damage: $damage. Remaining health: " . $defender->getHealth() . "\n";
    }
    abstract function defence(Character $attacker);
    abstract function attack(Character $defender);
    abstract function getName();
}
