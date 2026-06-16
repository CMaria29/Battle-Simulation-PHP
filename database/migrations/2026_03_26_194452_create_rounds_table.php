<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            // Legătura cu jocul respectiv
            $table->foreignId('game_id')->constrained()->onDelete('cascade');

            $table->integer('round_number');
            $table->string('attacker_name');
            $table->integer('damage_done')->default(0);

            $table->integer('hero_health');    // Health-ul rămas după rundă
            $table->integer('monster_health'); // Health-ul rămas după rundă

            $table->integer('defender_health_left');

            $table->text('log_message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rounds');
    }
};
