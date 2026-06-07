<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sobre nosotros — ComicBloom</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-bloom-bg dark:bg-bloom-dark min-h-screen">

<nav class="sticky top-0 z-50 bg-white/80 dark:bg-bloom-dark-alt/80 backdrop-blur-md border-b border-bloom-purple-light dark:border-bloom-dark-card">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('welcome') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-white font-extrabold text-sm">CB</div>
            <span class="font-extrabold text-bloom-text dark:text-white text-lg">ComicBloom</span>
        </a>
        <a href="{{ route('welcome') }}" class="text-sm font-bold text-bloom-muted hover:text-bloom-purple transition-colors">← Volver</a>
    </div>
</nav>

<main class="max-w-4xl mx-auto px-6 py-16">
    <div class="text-center mb-12">
        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-2xl mx-auto mb-4">🌸</div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-bloom-text dark:text-white mb-3">Sobre ComicBloom</h1>
        <p class="text-bloom-muted dark:text-purple-300 text-lg max-w-xl mx-auto">Una plataforma hecha con amor para los amantes de los cómics Marvel.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <div class="bg-white dark:bg-bloom-dark-alt rounded-3xl p-8 shadow-soft">
            <div class="w-10 h-10 rounded-2xl bg-bloom-purple-light dark:bg-bloom-dark-card flex items-center justify-center text-xl mb-4">📖</div>
            <h2 class="text-xl font-extrabold text-bloom-text dark:text-white mb-3">Nuestra historia</h2>
            <p class="text-bloom-muted dark:text-purple-200 leading-relaxed">
                ComicBloom nació de la pasión por los cómics y el deseo de tener una plataforma bonita donde organizar tus lecturas. Sergio se dio cuenta de que faltaba una app que fuera tan visual y fluida como Spotify, pero para el universo Marvel.
            </p>
        </div>
        <div class="bg-white dark:bg-bloom-dark-alt rounded-3xl p-8 shadow-soft">
            <div class="w-10 h-10 rounded-2xl bg-bloom-pink-light flex items-center justify-center text-xl mb-4">🎯</div>
            <h2 class="text-xl font-extrabold text-bloom-text dark:text-white mb-3">Nuestra misión</h2>
            <p class="text-bloom-muted dark:text-purple-200 leading-relaxed">
                Hacer que descubrir y organizar cómics Marvel sea una experiencia visual, fluida y emocionante. Creemos que los cómics merecen una plataforma tan cuidada como la música o las series.
            </p>
        </div>
    </div>

    {{-- Team --}}
    <div class="bg-white dark:bg-bloom-dark-alt rounded-3xl p-8 shadow-soft mb-8 text-center">
        <h2 class="text-xl font-extrabold text-bloom-text dark:text-white mb-6">El equipo</h2>
        <div class="flex justify-center">
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-bloom-purple-light shadow-soft mb-3">
                    <img src="{{ asset('img/Foto_Sergio.jpeg') }}" alt="Sergio Ruiz" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=Sergio+Ruiz&background=B892FF&color=fff&size=96'">
                </div>
                <p class="font-extrabold text-bloom-text dark:text-white">Sergio Ruiz</p>
                <p class="text-sm text-bloom-muted dark:text-purple-300">Fundador & Desarrollador</p>
                <div class="flex gap-3 mt-3">
                    <a href="https://github.com/ruimar-dev" target="_blank" class="text-bloom-muted hover:text-bloom-purple transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="https://x.com/ruimardev" target="_blank" class="text-bloom-muted hover:text-bloom-purple transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.742l7.732-8.855L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('contact.index') }}" class="btn-primary text-base">Contáctanos</a>
    </div>
</main>

</body>
</html>
