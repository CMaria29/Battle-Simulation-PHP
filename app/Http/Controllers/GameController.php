<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\GameEngine\GameLoop;
// Importăm funcțiile sau clasele din factory (dacă factory e clasă)
// Presupunem că ai mutat funcțiile în App\GameEngine\GameFactory
use App\GameEngine\GameFactory;

class GameController extends Controller
{
    public function start()
    {
        // În loc de createRandomMonster(), probabil vei folosi o metodă statică
        $monster = GameFactory::createRandomMonster();
        $hero = GameFactory::createRandomHero();


        $gameLoop = new GameLoop($monster, $hero);
        $gameLoop->gameStart();
        $game = Game::with('rounds')->latest()->first();
        // 4. Trimitem datele către view
        return view('game_status', [
            'game' => $game
        ]);
    }

    public function history() {
        // Luăm toate jocurile, ordonate de la cel mai recent
        $games = Game::orderBy('created_at', 'desc')->get();

        return view('history.index', compact('games'));
    }
    public function lastGame() {
        // Luăm ultimul joc creat, împreună cu rundele sale
        $lastGame = Game::with('rounds')->latest()->first();

        // Verificăm dacă există (latest()->first() returnează null dacă tabela e goală)
        if (!$lastGame) {
            return redirect()->route('app.open')->with('error', 'Nu există jocuri anterioare.');
        }

        return view('history.last', [
            'game' => $lastGame
        ]);
    }
}
