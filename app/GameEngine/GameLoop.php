<?php
namespace App\GameEngine;
class GameLoop
{
    private $attacker;
    private $defender;

    public function __construct($monster, $hero)
    {

        if ($monster->getSpeed() > $hero->getSpeed()) {
            $this->attacker = $monster;
            $this->defender = $hero;
        } elseif ($monster->getSpeed() < $hero->getSpeed()) {
            $this->attacker = $hero;
            $this->defender = $monster;
        } else {
            // egalitate la speed -> verificăm luck
            if ($monster->getLuck() > $hero->getLuck()) {
                $this->attacker = $monster;
                $this->defender = $hero;
            } else {
                $this->attacker = $hero;
                $this->defender = $monster;
            }
        }
    }

    public function gameStart()
    {
        // 1. Salvăm începutul jocului în DB
        $gameRecord = \App\Models\Game::create([
            'hero_stats' => [
                'health' => ($this->attacker->getName() == 'Kratos') ? $this->attacker->getHealth() : $this->defender->getHealth(),
                // Adaugă restul de stats aici...
                'strength' => ($this->attacker->getName() == 'Kratos') ? $this->attacker->getStrength() : $this->defender->getStrength()
            ],
            'monster_stats' => [
                'health' => ($this->attacker->getName() == 'Kratos') ? $this->defender->getHealth() : $this->attacker->getHealth(),
                'strength' => ($this->attacker->getName() == 'Kratos') ? $this->defender->getStrength() : $this->attacker->getStrength(),
            ],
        ]);
        for ($round = 1; $round <= 15; $round++) {
            // Păstrăm log-ul tău vizual pentru interfață
            $roundLog = "Round $round: ";

            // Executăm atacul (presupun că metoda attack returnează un string cu detalii)
            $attackDetails = $this->attacker->attack($this->defender);



            // Adăugăm în log-ul tău existent
            $logEntry = $roundLog . $attackDetails . " ";
            $logEntry .= "{$this->defender->getName()} health left: {$this->defender->getHealth()} ";

            // Verificăm finalul
            if ($this->defender->getHealth() <= 0) {
                $winner = $this->attacker->getName();
                $logEntry .= "Game over! $winner wins! ";
            }
            // 2. SALVĂM RUNDA ÎN BAZA DE DATE
            $gameRecord->rounds()->create([
                'round_number' => $round,
                'attacker_name' => $this->attacker->getName(),
                'damage_done' => $this->attacker->getDamage($this->defender), // Ar trebui să extragi valoarea din metoda attack
                'hero_health' =>  ($this->attacker->getName() == 'Kratos') ? $this->attacker->getHealth() : $this->defender->getHealth(),
                'monster_health' => ($this->attacker->getName() == 'Kratos') ? $this->defender->getHealth() : $this->attacker->getHealth(),
                'defender_health_left' => $this->defender->getHealth(),
                'log_message' => $logEntry
            ]);
            if ($this->defender->getHealth() <= 0) {
                // 3. ACTUALIZĂM CÂȘTIGĂTORUL ÎN DB
                $winner = $this->attacker->getName();
                $gameRecord->update(['winner' => $winner]);
                break;
            }

            $this->swapPlayers();
        }

    }

    private function swapPlayers()
    {
        $temp = $this->attacker;
        $this->attacker = $this->defender;
        $this->defender = $temp;
    }
}
