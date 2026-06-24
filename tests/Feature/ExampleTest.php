<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Round;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{


    public function test_game_and_rounds_are_created()
    {
        $this->withoutExceptionHandling(); // <--- Add this temporarily
        // 1. Executăm acțiunea (pornirea jocului)
        $response = $this->get('/start-game');

        // 2. Verificăm răspunsul
        $response->assertStatus(200);

        // 3. Verificăm că există un joc în DB
        $this->assertDatabaseHas('games', []);

        // 4. Verificăm că există cel puțin o rundă salvată
        // Luăm ultimul joc creat pentru a-i verifica relațiile
        $game = Game::latest()->first();

        $this->assertDatabaseHas('rounds', [
            'game_id' => $game->id,
            'round_number' => 1 // Presupunând că prima rundă e mereu 1
        ]);

        // Verificăm și prin relația Eloquent
        $this->assertGreaterThan(0, $game->rounds->count());
    }
}
