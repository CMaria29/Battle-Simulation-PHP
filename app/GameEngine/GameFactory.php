<?php

namespace App\GameEngine;

// Importăm clasele din folderul Characters
use App\GameEngine\characters\Hero;
use App\GameEngine\characters\Monster;

class GameFactory
{
    public static function createRandomHero()
    {
        $health = rand(65, 100);
        $strength = rand(75, 90);
        $defence = rand(40, 50);
        $speed = rand(40, 50);
        $luck = rand(10, 20);


        return new Hero($strength, $health, $defence, $luck, $speed);
    }

    public static function createRandomMonster()
    {
        $health = rand(50, 80);
        $strength = rand(55, 80);
        $defence = rand(50, 70);
        $speed = rand(40, 60);
        $luck = rand(30, 45);

        return new Monster($strength, $health, $defence, $luck, $speed);
    }
}
