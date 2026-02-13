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
                <div id="gate-background" class="bg-neutral-gate"></div>
                <div id="gate-left" class="gate-panel"></div>
                <div id="gate-right" class="gate-panel"></div>
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
