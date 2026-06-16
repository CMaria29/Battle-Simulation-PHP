<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\GameEngine\characters\Monster;
use App\GameEngine\characters\Hero;
class ExampleTest extends TestCase
{

    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
    public function test_damage_is_calculated_correctly()
    {
        // Attacker: strength 80
        $attacker = new Hero(80, 100, 40, 0, 50);

        // Defender: defence 50
        $defender = new Monster(60, 100, 50, 0, 40);

        $damage = $attacker->getDamage($defender);

        $this->assertEquals(30, $damage); // 80 - 50 = 30
    }
    public function test_magic_armour_reduces_damage_by_half()
    {
        // Attacker simplu, damage clar
        $attacker = new Monster(80, 100, 40, 0, 50); // strength=80, health=100
        $defender = new Hero(60, 100, 50, 0, 40); // defence=50, health=100

        // Damage normal ar fi 80-50 = 30
        $expectedReducedDamage = 30 / 2; // Magic Armour reduce la jumătate

        // Activează skill
        $message = $defender->skills['magicArmour']->activateSkills($attacker, $defender);


        // Verifică că health-ul a scăzut corect
        $this->assertEquals(100 - $expectedReducedDamage, $defender->getHealth());
    }
    public function test_attack_can_miss_due_to_luck()
    {
        $defender = new Monster(0,100,0,100,0); // always lucky

        $attacker = new Hero(80, 100, 40, 0, 50);
        $attacker->attack($defender);
        $this->assertEquals(100, $defender->getHealth());
    }
    public function test_rapid_fire_strikes_2_times()
    {
        // Attacker simplu, damage clar
        $defender = new Monster(80, 100, 40, 0, 50); // strength=80, health=100
        $attacker = new Hero(60, 100, 50, 0, 40); // defence=50, health=100

        // Damage normal ar fi 60-40 = 20
        $expectedReducedDamage = 20 *2 ;

        // Activează skill
        $attacker->skills['rapidFire']->activateSkills($attacker, $defender);


        // Verifică că health-ul a scăzut corect
        $this->assertEquals(100 - $expectedReducedDamage, $defender->getHealth());
    }

}
