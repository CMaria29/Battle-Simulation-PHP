<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat Journal | Relic & Ember</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap');

        body {
            background-color: #0c0c0c;
            color: #d4d4d8;
            font-family: 'Inter', sans-serif;
            background-image: radial-gradient(circle at center, #1a1a1a 0%, #0c0c0c 100%);
            padding: 20px;
        }

        h1, h3, .font-cinzel {
            font-family: 'Cinzel', serif;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .glass-panel {
            background: rgba(24, 24, 27, 0.8);
            border: 1px solid rgba(63, 63, 70, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 8px;
        }

        .winner-banner {
            font-family: 'Cinzel', serif;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }

        .hero-win { background: rgba(6, 78, 59, 0.4); color: #6ee7b7; border: 1px solid #059669; }
        .monster-win { background: rgba(69, 10, 10, 0.4); color: #f87171; border: 1px solid #991b1b; }

        th {
            background-color: #18181b;
            color: #f59e0b; /* Amber */
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }

        .round-number { color: #f59e0b; font-weight: bold; font-family: 'Cinzel', serif; }
        .damage-val { color: #ef4444; font-weight: bold; }
        .skill-tag { background: #1e3a8a; color: #bfdbfe; padding: 2px 6px; border-radius: 3px; font-size: 11px; font-style: italic; }
        .lucky-hit { color: #fbbf24; text-shadow: 0 0 8px rgba(251, 191, 36, 0.4); }
        .health-left { color: #10b981; font-weight: bold; }

        .back-btn:hover { color: #f59e0b; transform: translateX(-4px); }
    </style>
</head>
<body>

<div class="max-w-6xl mx-auto">
    <a href="{{ route('game.history') }}" class="back-btn inline-flex items-center gap-2 text-zinc-500 transition-all duration-300 mb-6">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        <span class="font-cinzel text-sm">Back to Archives</span>
    </a>

    <div class="glass-panel p-6 mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <h1 class="text-2xl text-amber-500 mb-1">Combat Journal #{{ $game->id }}</h1>
            <p class="text-zinc-500 text-xs font-mono uppercase tracking-widest">
                Recorded on: {{ $game->created_at->format('M d, Y | H:i') }}
            </p>
        </div>

        <div class="winner-banner {{ $game->winner === 'hero' ? 'hero-win' : 'monster-win' }}">
            VICTOR: {{ $game->winner === 'hero' ? ($game->hero_stats['name'] ?? 'HERO') : ($game->monster_stats['name'] ?? 'MONSTER') }}
            <small class="block text-[10px] opacity-70 mt-1 font-sans uppercase tracking-tighter">
                Reason: {{ str_replace('_', ' ', $game->end_reason) }}
            </small>
        </div>
    </div>

    <div class="glass-panel overflow-hidden">
        <h3 class="p-4 bg-zinc-900/50 text-sm text-zinc-400 border-b border-zinc-800">Sequential Battle Logs</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr>
                    <th class="p-4 uppercase">Rnd</th>
                    <th class="p-4 uppercase text-zinc-300">Attacker</th>
                    <th class="p-4 uppercase text-zinc-300">Damage</th>
                    <th class="p-4 uppercase text-zinc-300">Ability</th>
                    <th class="p-4 uppercase text-zinc-300">Luck</th>
                    <th class="p-4 uppercase text-zinc-300">Def. Health</th>
                    <th class="p-4 uppercase text-zinc-300">Log Entry</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/50">
                @forelse($game->rounds as $round)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="p-4 round-number">#{{ str_pad($round->round_number, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-4 text-sm font-semibold text-zinc-200">{{ $round->attacker_name }}</td>
                        <td class="p-4 text-sm damage-val">-{{ $round->damage_done }}</td>
                        <td class="p-4">
                            @if($round->skill_used)
                                <span class="skill-tag">{{ $round->skill_used }}</span>
                            @else
                                <span class="text-zinc-700 text-[10px] uppercase">Normal</span>
                            @endif
                        </td>
                        <td class="p-4 text-sm">
                            @if($round->was_lucky)
                                <span class="lucky-hit font-bold">CRIT ✨</span>
                            @else
                                <span class="text-zinc-600">No</span>
                            @endif
                        </td>
                        <td class="p-4 text-sm health-left">
                            {{ $round->defender_health_left }} <small class="text-zinc-600">VIT</small>
                        </td>
                        <td class="p-4 text-xs italic text-zinc-500 leading-relaxed max-w-xs">
                            "{{ $round->log_message }}"
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-10 text-center text-zinc-600 italic font-cinzel uppercase tracking-widest">
                            The chronicles are empty for this battle.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex justify-center opacity-10">
        <span class="material-symbols-outlined text-amber-500 scale-150">history_edu</span>
    </div>
</div>

</body>
</html>
