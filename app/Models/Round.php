<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Round extends Model
{
    // Câmpurile pe care avem voie să le umplem dintr-un array
    protected $fillable = [
        'game_id',
        'round_number',
        'attacker_name',
        'damage_done',
        'defender_health_left',
        'log_message',
        'hero_health',
        'monster_health'
    ];

    // Spunem modelului că aparține unui Game
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
