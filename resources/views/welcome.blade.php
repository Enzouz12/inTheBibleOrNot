<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Est-ce dans la Bible ?</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-900 text-white min-h-screen flex flex-col items-center">

    <header class="w-full text-center py-8">
        <h1 class="text-4xl font-bold tracking-tight">Est-ce dans la Bible ?</h1>
        <p class="text-stone-400 mt-2">Tapez du texte et découvrez quels mots se trouvent dans la Bible</p>
    </header>

    <main class="w-full max-w-3xl px-4 flex flex-col gap-6 pb-12">

        <!-- Gate Visual -->
        <div id="gate-container">
            <div id="gate-scene">
                <div id="gate-background" class="bg-neutral-gate">

                    {{-- Heaven scene --}}
                    <div id="heaven-scene" class="scene-layer">
                        <div class="heaven-rays"></div>
                        <div class="cloud" style="--x:8%;--y:12%;--w:90px;--h:30px;--dur:7s;--delay:0s"></div>
                        <div class="cloud" style="--x:55%;--y:6%;--w:110px;--h:34px;--dur:9s;--delay:2s"></div>
                        <div class="cloud" style="--x:28%;--y:28%;--w:70px;--h:24px;--dur:8s;--delay:4s"></div>
                        <svg class="heaven-angel" viewBox="0 0 100 110" fill="none">
                            {{-- Halo --}}
                            <ellipse cx="50" cy="10" rx="14" ry="5" stroke="rgba(253,224,71,0.9)" stroke-width="2.5"/>
                            <ellipse cx="50" cy="10" rx="14" ry="5" stroke="rgba(253,224,71,0.3)" stroke-width="6"/>
                            {{-- Head --}}
                            <circle cx="50" cy="26" r="9" fill="rgba(253,224,71,0.5)"/>
                            {{-- Body / robe --}}
                            <path d="M50 35 L66 80 L34 80 Z" fill="rgba(253,224,71,0.25)" stroke="rgba(253,224,71,0.35)" stroke-width="1"/>
                            {{-- Left wing --}}
                            <path d="M40 38 C18 26 10 50 26 72" fill="rgba(253,224,71,0.12)" stroke="rgba(253,224,71,0.4)" stroke-width="1.5"/>
                            <path d="M38 42 C22 34 16 52 28 68" fill="rgba(253,224,71,0.08)" stroke="rgba(253,224,71,0.25)" stroke-width="1"/>
                            {{-- Right wing --}}
                            <path d="M60 38 C82 26 90 50 74 72" fill="rgba(253,224,71,0.12)" stroke="rgba(253,224,71,0.4)" stroke-width="1.5"/>
                            <path d="M62 42 C78 34 84 52 72 68" fill="rgba(253,224,71,0.08)" stroke="rgba(253,224,71,0.25)" stroke-width="1"/>
                        </svg>
                        <div class="sparkle" style="--x:18%;--y:35%;--dur:2s;--delay:0s"></div>
                        <div class="sparkle" style="--x:78%;--y:22%;--dur:2.5s;--delay:0.6s"></div>
                        <div class="sparkle" style="--x:42%;--y:60%;--dur:1.8s;--delay:1.1s"></div>
                        <div class="sparkle" style="--x:88%;--y:55%;--dur:2.2s;--delay:1.7s"></div>
                        <div class="sparkle" style="--x:12%;--y:65%;--dur:2.6s;--delay:0.3s"></div>
                    </div>

                    {{-- Hell scene --}}
                    <div id="hell-scene" class="scene-layer">
                        <div class="flame" style="--x:2%;--w:50px;--h:110px;--dur:1.1s;--delay:0s"></div>
                        <div class="flame" style="--x:14%;--w:40px;--h:85px;--dur:1.4s;--delay:0.2s"></div>
                        <div class="flame" style="--x:26%;--w:55px;--h:130px;--dur:1.0s;--delay:0.5s"></div>
                        <div class="flame" style="--x:40%;--w:45px;--h:100px;--dur:1.3s;--delay:0.15s"></div>
                        <div class="flame" style="--x:54%;--w:50px;--h:120px;--dur:1.15s;--delay:0.35s"></div>
                        <div class="flame" style="--x:66%;--w:38px;--h:90px;--dur:1.5s;--delay:0.45s"></div>
                        <div class="flame" style="--x:78%;--w:52px;--h:115px;--dur:1.2s;--delay:0.25s"></div>
                        <div class="flame" style="--x:90%;--w:44px;--h:95px;--dur:1.35s;--delay:0.6s"></div>
                        {{-- Pitchfork --}}
                        <svg class="hell-pitchfork" viewBox="0 0 60 120" fill="none">
                            <line x1="30" y1="118" x2="30" y2="40" stroke="#78716c" stroke-width="4" stroke-linecap="round"/>
                            <line x1="30" y1="40" x2="30" y2="10" stroke="#78716c" stroke-width="3.5" stroke-linecap="round"/>
                            <path d="M30 40 Q16 33 10 10" stroke="#78716c" stroke-width="3.5" fill="none" stroke-linecap="round"/>
                            <path d="M30 40 Q44 33 50 10" stroke="#78716c" stroke-width="3.5" fill="none" stroke-linecap="round"/>
                            <circle cx="30" cy="7" r="3.5" fill="#a8a29e"/>
                            <circle cx="8" cy="7" r="3.5" fill="#a8a29e"/>
                            <circle cx="52" cy="7" r="3.5" fill="#a8a29e"/>
                        </svg>
                        {{-- Horns --}}
                        <svg class="hell-horns" viewBox="0 0 140 55" fill="none">
                            <path d="M48 52 C42 35 28 20 8 2" stroke="#991b1b" stroke-width="7" stroke-linecap="round"/>
                            <path d="M48 52 C42 35 28 20 8 2" stroke="#b91c1c" stroke-width="4" stroke-linecap="round"/>
                            <path d="M92 52 C98 35 112 20 132 2" stroke="#991b1b" stroke-width="7" stroke-linecap="round"/>
                            <path d="M92 52 C98 35 112 20 132 2" stroke="#b91c1c" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                        {{-- Embers --}}
                        <div class="ember" style="--x:12%;--dur:2.5s;--delay:0s;--drift:18px"></div>
                        <div class="ember" style="--x:28%;--dur:3.1s;--delay:0.5s;--drift:-22px"></div>
                        <div class="ember" style="--x:48%;--dur:2.8s;--delay:1s;--drift:12px"></div>
                        <div class="ember" style="--x:62%;--dur:3.3s;--delay:0.3s;--drift:-16px"></div>
                        <div class="ember" style="--x:78%;--dur:2.6s;--delay:0.8s;--drift:22px"></div>
                        <div class="ember" style="--x:38%;--dur:3.6s;--delay:1.5s;--drift:-12px"></div>
                        <div class="ember" style="--x:85%;--dur:2.9s;--delay:0.2s;--drift:14px"></div>
                    </div>

                </div>
                <div id="gate-left" class="gate-panel"></div>
                <div id="gate-right" class="gate-panel"></div>
            </div>

            {{-- Stairway --}}
            <div id="stairway">
                <div class="stair"></div>
                <div class="stair"></div>
                <div class="stair"></div>
                <div class="stair"></div>
                <div class="stair"></div>
            </div>

            <div id="gate-label" class="text-stone-400 text-center mt-3 text-sm font-medium">Les portes attendent vos mots...</div>
        </div>

        <!-- Stats -->
        <div class="flex justify-center gap-8 text-sm font-medium">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                Dans la Bible : <span id="stat-in" class="text-emerald-400 font-bold">0</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                Absents : <span id="stat-out" class="text-red-400 font-bold">0</span>
            </div>
        </div>

        <!-- Input -->
        <textarea
            id="word-input"
            rows="4"
            placeholder="Tapez votre texte ici... (ex: Dieu est amour)"
            class="w-full rounded-lg bg-stone-800 border border-stone-700 text-white p-4 text-lg placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 resize-y"
        ></textarea>

        <!-- Word Display -->
        <div id="word-display" class="min-h-[3rem] rounded-lg bg-stone-800/50 border border-stone-700/50 p-4 flex flex-wrap gap-2 text-lg leading-relaxed"></div>

    </main>

</body>
</html>
