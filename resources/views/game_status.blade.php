<!DOCTYPE html>

<html class="dark" lang="en"><head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Relic &amp; Ember - Combat Codex</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,400;0,700;0,800;1,400;1,800&amp;family=Space+Grotesk:wght@300;400;500;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-tertiary-fixed-variant": "#46464e",
                        "on-tertiary-fixed": "#1a1b22",
                        "surface-container-low": "#1b1b1e",
                        "on-primary-fixed": "#410002",
                        "primary-fixed": "#ffdad6",
                        "tertiary": "#c6c5cf",
                        "inverse-on-surface": "#303033",
                        "on-primary": "#690007",
                        "on-secondary": "#472a00",
                        "inverse-primary": "#b02d29",
                        "surface-container-lowest": "#0e0e11",
                        "primary-fixed-dim": "#ffb4ac",
                        "outline-variant": "#59413e",
                        "on-background": "#e4e1e6",
                        "on-primary-fixed-variant": "#8e1214",
                        "surface-container-highest": "#353438",
                        "background": "#131316",
                        "tertiary-container": "#4d4e56",
                        "on-error-container": "#ffdad6",
                        "surface": "#131316",
                        "surface-container-high": "#2a2a2d",
                        "secondary-container": "#ee9800",
                        "surface-tint": "#ffb4ac",
                        "on-surface-variant": "#e1bfbb",
                        "secondary-fixed": "#ffddb8",
                        "on-secondary-container": "#5b3800",
                        "error-container": "#93000a",
                        "on-secondary-fixed": "#2a1700",
                        "surface-variant": "#353438",
                        "on-tertiary": "#2f3038",
                        "outline": "#a88a86",
                        "secondary": "#ffb95f",
                        "on-surface": "#e4e1e6",
                        "tertiary-fixed-dim": "#c6c5cf",
                        "on-secondary-fixed-variant": "#653e00",
                        "surface-dim": "#131316",
                        "on-error": "#690005",
                        "secondary-fixed-dim": "#ffb95f",
                        "tertiary-fixed": "#e3e1ec",
                        "surface-container": "#1f1f22",
                        "on-tertiary-container": "#c0bfc9",
                        "primary": "#ffb4ac",
                        "error": "#ffb4ab",
                        "primary-container": "#991b1b",
                        "surface-bright": "#39393c",
                        "inverse-surface": "#e4e1e6",
                        "on-primary-container": "#ffaaa1"
                    },
                    fontFamily: {
                        "headline": ["Newsreader", "serif"],
                        "body": ["Space Grotesk", "sans-serif"],
                        "label": ["Space Grotesk", "monospace"]
                    },
                    borderRadius: {"DEFAULT": "0px", "lg": "0px", "xl": "0px", "full": "9999px"},
                },
            },
        }
    </script>
    <script>
        // Transformăm colecția de runde din PHP în obiect JS
        // Presupunem că $game->rounds are coloanele 'hero_health', 'monster_health' și 'log'
        const battleRounds = {!! json_encode($game->rounds ?? []) !!};
        const maxHeroHP = 100;
        const maxMonsterHP = 100;
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .relic-card-clip {
            clip-path: polygon(0 0, 100% 0, 100% 90%, 95% 100%, 0 100%);
        }
        .grain-overlay {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.05;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body selection:bg-primary/30 min-h-screen flex flex-col overflow-y-auto">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 flex justify-between items-center px-6 py-4 bg-zinc-950/80 backdrop-blur-xl bg-zinc-900 shadow-[0_1px_0_0_rgba(255,185,95,0.1)]">
    <div class="flex items-center gap-4">
        <span class="font-serif italic font-black text-red-700 dark:text-red-600 tracking-widest uppercase">Relic &amp; Ember</span>
    </div>
    <nav class="hidden md:flex items-center gap-8">
        <a class="text-amber-500 font-bold font-serif text-2xl tracking-tighter uppercase transition-colors duration-300" href="#">Command</a>
        <a class="text-zinc-500 font-serif text-2xl tracking-tighter uppercase hover:text-amber-400 transition-colors duration-300" href="#">Relics</a>
        <a class="text-zinc-500 font-serif text-2xl tracking-tighter uppercase hover:text-amber-400 transition-colors duration-300" href="#">Codex</a>
    </nav>
    <div class="flex items-center gap-4 text-zinc-500">
        <a href="{{ route('game.history') }}" class="material-symbols-outlined hover:text-amber-400 transition-colors duration-300 scale-95 active:duration-75 decoration-none">
            history
        </a>

    </div>
</header>
<!-- Main Battle Canvas -->
<main class="flex-grow pt-24 pb-32 px-4 md:px-8 relative">
    <div class="absolute inset-0 grain-overlay z-0"></div>
    <!-- Blood/Smoke Textures -->
    <div class="absolute inset-0 opacity-20 pointer-events-none z-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-primary-container/20 via-transparent to-surface-container-lowest/40"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-primary-container blur-[120px] rounded-full"></div>
    </div>
    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center h-full max-w-7xl mx-auto">
        <!-- Left: Hero Card (Ancient Spartan Warrior) -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            <div class="relic-card-clip bg-surface-container-high p-1 shadow-[0_0_32px_rgba(153,27,27,0.1)] border-l-4 border-primary">
                <div class="bg-surface-container-low p-4">
                    <div class="aspect-[3/4] mb-4 bg-zinc-900 relative group overflow-hidden">
                        <img alt="Malakai the Voidborn" class="w-full h-full object-cover filter grayscale hover:grayscale-0 transition-all duration-700" data-alt="Intense close-up portrait of a scarred ancient Spartan warrior in bronze helmet with red plume, dramatic cinematic lighting, gritty texture" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDCU6AkiTxPy-lkPueqtN6YbLoRMVmFr6KaCdoZQRvY-sl9qljXxSGr4zZkzRg-W3zufTOw7iJMK5Cf2sovRFLDTlh_Ec9nEamTE2FCsXC5OiaMU0R7h-mZCTl5M8RdZJqT5IeBto6yyXh4XraZVKEoV8_Bbh8EwtY6cHuo51mtoi1wXn8iA8qQXtOUXq42C3aUlvOCWsNFPV_0bWOXSgBF3Vx22IYSaGQxZk9AqW21EGoBfMhkw0VPvnI_mBdNBnum3ekrJspJHfA"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest to-transparent opacity-60"></div>
                    </div>
                    <h2 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight mb-1 uppercase italic">Kratos</h2>
                    <p class="font-label text-xs tracking-[0.2em] text-secondary mb-4">DARK PALADIN</p>
                    <!-- Health Bar -->
                    <div class="mb-6">
                        <div class="flex justify-between items-end mb-1">
                            <span class="font-label text-[10px] text-on-surface-variant uppercase tracking-widest">Vitality</span>
                            <span id="hero-hp-text" class="font-label text-sm text-primary font-bold">100 / 100</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-lowest overflow-hidden">
                            <div id="hero-bar" class="h-full bg-gradient-to-r from-on-primary-fixed-variant to-primary shadow-[0_0_12px_rgba(255,180,172,0.3)] transition-all duration-1000" style="width: 100%"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Center: Actions -->
        <div class="lg:col-span-4 flex flex-col items-center justify-center gap-6">
            <button class="group relative px-12 py-6 bg-primary-container hover:bg-on-primary-fixed-variant transition-all duration-300 overflow-hidden shadow-[0_0_40px_rgba(153,27,27,0.4)]">
                <div class="absolute inset-0 grain-overlay opacity-20"></div>
                <a href="{{ route('game.start') }}" class="group relative px-12 py-6 bg-primary-container hover:bg-on-primary-fixed-variant transition-all duration-300 overflow-hidden shadow-[0_0_40px_rgba(153,27,27,0.4)] inline-block">
                    <div class="absolute inset-0 grain-overlay opacity-20"></div>
                    <span class="relative z-10 font-headline text-2xl font-black text-on-primary-container tracking-widest uppercase italic group-active:scale-95 transition-transform">
                        Battle
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-black/20 pointer-events-none"></div>
                </a>

            </button>
            <div class="flex gap-4">
                <a href="{{ route('game.last') }}"
                   class="p-3 bg-surface-container-high border border-outline-variant/30 hover:border-secondary transition-colors text-on-surface-variant hover:text-secondary inline-flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">history</span>
                </a>

            </div>
        </div>
        <!-- Right: Enemy Card (Forest Beast) -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            <div class="relic-card-clip bg-surface-container-high p-1 shadow-[0_0_32px_rgba(153,27,27,0.05)] border-r-4 border-zinc-700">
                <div class="bg-surface-container-low p-4">
                    <div class="aspect-[3/4] mb-4 bg-zinc-900 relative overflow-hidden">
                        <img alt="Shadow Stalker" class="w-full h-full object-cover grayscale brightness-75 transition-all duration-700" data-alt="Monstrous forest beast with glowing eyes and matted fur in a dark foggy woodland, low angle shot, dark fantasy concept art" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPXSQeZHlESMbIoBFkaKxkY5a0y91SfezisutFM_F0Tge_1XZRNxWvOHU0zE7DmnV5psV86qNch8UeaAA-idIZfiqYvBoczBEBb1U6WA4vD8h8rd4zsYv0A3_dIrcGtBQVEAh2SaChPhesKFNlV2-IfaP5VZEKWpe5Ywsjf98j_KAzva1qf_2t7d5el36Qmjlg7pgAp0QzHL9pDXXfhihy1DxrS6KDnHXffUoyH34GWM2NMEUdFIam2pQn_H8Wku-r3g5ZycWDMxU"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest/80 to-transparent"></div>
                        <div class="absolute top-2 right-2 px-2 py-1 bg-error-container/80 text-on-error-container font-label text-[10px] uppercase">Threat: High</div>
                    </div>
                    <h2 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight mb-1 uppercase italic text-right">The Monster</h2>
                    <p class="font-label text-xs tracking-[0.2em] text-zinc-500 mb-4 text-right">NIGHTMARE CREATURE</p>
                    <!-- Health Bar (Green to Red) -->
                    <div class="mb-6">
                        <div class="flex justify-between items-end mb-1">
                            <span id="monster-hp-text" class="font-label text-sm text-error font-bold">100 / 100</span>
                            <span class="font-label text-[10px] text-on-surface-variant uppercase tracking-widest">Resilience</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-lowest overflow-hidden">
                            <!-- Animates from right for enemy -->
                            <div id="monster-bar" class="h-full bg-gradient-to-l from-emerald-900 via-orange-900 to-red-900 shadow-[0_0_12px_rgba(244,67,54,0.2)] transition-all duration-1000" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="border-t border-outline-variant/20 pt-4 opacity-50">
                        <p class="font-label text-[10px] text-zinc-600 uppercase italic">Buffs: None</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Battle Log (Floating above Nav) -->
    <div class="fixed bottom-24 left-1/2 -translate-x-1/2 w-full max-w-4xl px-4 z-40">
        <div class="bg-surface-container-lowest/90 backdrop-blur-md border-t border-outline-variant/20 h-32 overflow-y-auto scrollbar-hide p-4 font-label text-sm leading-relaxed">
            <div id="battle-log-container" class="space-y-2">

            </div>
        </div>
    </div>
</main>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const logContainer = document.getElementById('battle-log-container');

        // Selectăm elementele folosind ID-urile directe pe care le-ai pus în HTML
        const heroBar = document.getElementById('hero-bar');
        const heroText = document.getElementById('hero-hp-text');
        const monsterBar = document.getElementById('monster-bar');
        const monsterText = document.getElementById('monster-hp-text');

        const delay = 1000;

        // Verificăm dacă avem runde de procesat
        if (typeof battleRounds !== 'undefined' && battleRounds.length > 0) {
            logContainer.innerHTML = ''; // Curățăm mesajul "The forest is quiet..."

            battleRounds.forEach((round, index) => {
                setTimeout(() => {
                    // 1. Actualizăm Textul (Cifrele)
                    if(heroText) heroText.innerText = `${round.hero_health} / ${maxHeroHP}`;
                    if(monsterText) monsterText.innerText = `${round.monster_health} / ${maxMonsterHP}`;

                    // 2. Actualizăm Barele (Procentajul vizual)
                    if(heroBar) {
                        let heroPercent = (round.hero_health / maxHeroHP) * 100;
                        heroBar.style.width = Math.max(0, heroPercent) + "%";
                    }

                    if(monsterBar) {
                        let monsterPercent = (round.monster_health / maxMonsterHP) * 100;
                        monsterBar.style.width = Math.max(0, monsterPercent) + "%";
                    }

                    // 3. Adăugăm mesajul în log
                    const logEntry = document.createElement('p');
                    logEntry.className = 'log-item opacity-100 transition-opacity duration-500 text-on-surface-variant flex items-start gap-3 border-l border-red-900/30 pl-3 mb-2 hover:bg-white/5';
                    logEntry.innerHTML = `
                    <span class="text-[10px] opacity-30 font-mono mt-1 shrink-0">${(index + 1).toString().padStart(2, '0')}</span>
                    <span class="leading-relaxed">${round.log_message}</span>
                    `;
                    logContainer.appendChild(logEntry);
                    // 4. Auto-scroll
                    const logWindow = logContainer.parentElement; // Containerul cu scroll

                }, index * delay);
            });
        }
    });
</script>
</body></html>
