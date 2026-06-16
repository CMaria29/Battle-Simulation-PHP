<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battle History | Relic & Ember</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap');

        body {
            background-color: #0c0c0c; /* Fundalul foarte închis din imagine */
            color: #d4d4d8;
            font-family: 'Inter', sans-serif;
            background-image: radial-gradient(circle at center, #1a1a1a 0%, #0c0c0c 100%);
        }

        h1, .font-cinzel {
            font-family: 'Cinzel', serif;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .glass-panel {
            background: rgba(24, 24, 27, 0.8);
            border: 1px solid rgba(63, 63, 70, 0.3);
            backdrop-filter: blur(10px);
        }

        .table-header {
            border-bottom: 2px solid #991b1b; /* Accent roșu închis */
            color: #f59e0b; /* Amber pentru titluri */
        }

        .status-badge {
            padding: 2px 8px;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1px;
            border-radius: 2px;
            text-transform: uppercase;
        }

        .winner-hero { background: #064e3b; color: #6ee7b7; border: 1px solid #059669; }
        .winner-monster { background: #450a0a; color: #f87171; border: 1px solid #991b1b; }

        .back-btn:hover {
            color: #f59e0b;
            transform: translateX(-4px);
        }
    </style>
</head>
<body class="p-4 md:p-10">

<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8 border-b border-zinc-800 pb-4">
        <div>
            <h1 class="text-3xl font-bold text-amber-500">Battle Archives</h1>
            <p class="text-zinc-500 text-xs mt-1">Review your past encounters within the void</p>
        </div>
        <a href="{{ route('app.open') }}" class="back-btn flex items-center gap-2 text-zinc-400 transition-all duration-300">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span class="font-cinzel text-sm">Return to Command</span>
        </a>
    </div>

    <div class="glass-panel rounded-lg overflow-hidden shadow-2xl">
        <table class="w-full border-collapse">
            <thead>
            <tr class="table-header bg-zinc-900/50">
                <th class="p-4 text-left text-xs uppercase tracking-widest">Date / Time</th>
                <th class="p-4 text-left text-xs uppercase tracking-widest text-zinc-300">Hero Stats</th>
                <th class="p-4 text-left text-xs uppercase tracking-widest text-zinc-300">Monster Stats</th>
                <th class="p-4 text-left text-xs uppercase tracking-widest text-zinc-300">Victor</th>

            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800/50">
            @forelse($games as $game)
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="p-4 text-sm text-zinc-400 font-mono">
                        {{ $game->created_at->format('M d, Y • H:i') }}
                    </td>

                    <td class="p-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-red-500 font-bold">{{ $game->hero_stats['health'] ?? '0' }}</span>
                            <span class="text-zinc-600">VIT</span>
                            <span class="text-zinc-400 ml-2">{{ $game->hero_stats['strength'] ?? '0' }}</span>
                            <span class="text-zinc-600">STR</span>
                        </div>
                    </td>

                    <td class="p-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-amber-600 font-bold">{{ $game->monster_stats['health'] ?? '0' }}</span>
                            <span class="text-zinc-600">RES</span>
                            <span class="text-zinc-400 ml-2">{{ $game->monster_stats['strength'] ?? '0' }}</span>
                            <span class="text-zinc-600">STR</span>
                        </div>
                    </td>

                    <td class="p-4">
                            <span class="badge {{ $game->winner === 'hero' ? 'winner-hero' : 'winner-monster' }}">
                            {{ strtoupper($game->winner) }}
                            </span>
                    </td>



                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-10 text-center text-zinc-600 italic font-cinzel">
                        No combat logs found in the archives.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center opacity-20">
        <div class="h-px w-24 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
        <span class="material-symbols-outlined text-amber-500 mx-4">swords</span>
        <div class="h-px w-24 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
    </div>
</div>

</body>
</html>
