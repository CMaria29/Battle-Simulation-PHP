<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // Permite salvarea în masă a acestor câmpuri
    protected $fillable = ['hero_stats', 'monster_stats', 'winner'];

    // Transformă automat JSON-ul din DB în Array de PHP
    protected $casts = [
        'hero_stats' => 'array',
        'monster_stats' => 'array',
    ];

    public function rounds() {
        return $this->hasMany(Round::class);
    }
}
