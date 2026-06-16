<?php
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/app', function () {
    return view('game_status');
})->name('app.open');
Route::get('/start-game', [GameController::class, 'start'])->name('game.start');
Route::get('/history', [GameController::class, 'history'])->name('game.history');
Route::get('/last-game', [GameController::class, 'lastGame'])->name('game.last');

