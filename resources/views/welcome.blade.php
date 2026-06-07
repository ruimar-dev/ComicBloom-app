<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ComicBloom — Descubre el universo Marvel</title>
    <link rel="icon" href="{{ asset('img/mobile-logo-claro.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-bloom-bg dark:bg-bloom-dark min-h-screen">

{{-- Nav --}}
<nav class="sticky top-0 z-50 bg-white/80 dark:bg-bloom-dark-alt/80 backdrop-blur-md border-b border-bloom-purple-light dark:border-bloom-dark-card">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-white font-extrabold text-sm">CB</div>
            <span class="font-extrabold text-bloom-text dark:text-white text-lg">ComicBloom</span>
        </div>
        <div class="flex items-center gap-3">
            @auth
            <a href="{{ route('dashboard') }}" class="btn-primary text-sm">Ir al inicio</a>
            @else
            <a href="{{ route('login') }}" class="btn-ghost text-sm">Entrar</a>
            <a href="{{ route('register') }}" class="btn-pink text-sm">Empezar gratis</a>
            @endauth
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="max-w-6xl mx-auto px-6 py-20 md:py-28 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 text-center md:text-left">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-bloom-purple-light dark:bg-bloom-dark-card text-bloom-purple text-sm font-bold rounded-full mb-6">
            ✨ Tu plataforma de cómics Marvel
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-bloom-text dark:text-white leading-tight mb-6">
            Descubre, guarda<br>y organiza tus<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-bloom-pink to-bloom-purple">cómics favoritos</span>
        </h1>
        <p class="text-lg text-bloom-muted dark:text-purple-200 mb-8 max-w-lg">
            Explora el universo Marvel, crea tu biblioteca personal y sigue tu progreso de lectura. Todo en un solo lugar.
        </p>
        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
            <a href="{{ route('register') }}" class="btn-pink text-base">Empezar gratis</a>
            <a href="{{ route('explore') }}" class="btn-ghost text-base">Explorar demo</a>
        </div>
    </div>
    <div class="flex-none flex gap-4 md:gap-3">
        <div class="flex flex-col gap-4 mt-8 md:mt-0">
            <div class="w-32 md:w-36 rounded-3xl overflow-hidden shadow-soft-lg rotate-[-4deg] hover:rotate-0 transition-transform duration-300">
                <img src="https://i.annihil.us/u/prod/marvel/i/mg/c/80/52cbbc8b9c4cc/portrait_uncanny.jpg" alt="Comic" class="w-full" onerror="this.src='{{ asset('img/portada.png') }}'">
            </div>
            <div class="w-32 md:w-36 rounded-3xl overflow-hidden shadow-soft-lg rotate-[3deg] hover:rotate-0 transition-transform duration-300">
                <img src="https://i.annihil.us/u/prod/marvel/i/mg/9/c0/515523f9c3c50/portrait_uncanny.jpg" alt="Comic" class="w-full" onerror="this.src='{{ asset('img/iluminati.png') }}'">
            </div>
        </div>
        <div class="flex flex-col gap-4 mt-[-16px]">
            <div class="w-32 md:w-36 rounded-3xl overflow-hidden shadow-soft-lg rotate-[2deg] hover:rotate-0 transition-transform duration-300">
                <img src="https://i.annihil.us/u/prod/marvel/i/mg/3/40/4bb4680432f73/portrait_uncanny.jpg" alt="Comic" class="w-full" onerror="this.src='{{ asset('img/portada.png') }}'">
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="bg-white dark:bg-bloom-dark-alt py-16 md:py-20">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-center text-bloom-text dark:text-white mb-12">Todo lo que necesitas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ([
                ['🔍', 'Descubre', 'Explora miles de cómics del universo Marvel con un buscador potente.', 'from-bloom-blue to-bloom-purple'],
                ['📚', 'Organiza', 'Crea tu biblioteca personal y clasifica tus cómics como quieras.', 'from-bloom-purple to-bloom-pink'],
                ['📖', 'Sigue tu progreso', 'Marca tus cómics como Sin leer, Leyendo o Leído fácilmente.', 'from-bloom-pink to-bloom-yellow'],
                ['❤️', 'Guarda favoritos', 'Marca tus cómics favoritos para encontrarlos siempre a mano.', 'from-bloom-yellow to-bloom-mint'],
            ] as [$icon, $title, $desc, $gradient])
            <div class="bg-bloom-bg dark:bg-bloom-dark-card rounded-3xl p-6 hover:shadow-card-hover transition-shadow duration-300">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $gradient }} flex items-center justify-center text-2xl mb-4">{{ $icon }}</div>
                <h3 class="font-extrabold text-bloom-text dark:text-white mb-2">{{ $title }}</h3>
                <p class="text-bloom-muted dark:text-purple-300 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="max-w-6xl mx-auto px-6 py-20 text-center">
    <div class="bg-gradient-to-r from-bloom-purple to-bloom-pink rounded-4xl p-12 text-white">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-4">¿Listo para explorar?</h2>
        <p class="text-white/80 text-lg mb-8">Únete gratis y empieza a construir tu biblioteca Marvel hoy.</p>
        <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-bloom-purple font-extrabold rounded-2xl hover:bg-bloom-bg transition-colors text-base shadow-soft-lg">
            Crear cuenta gratis
        </a>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-white dark:bg-bloom-dark-alt border-t border-bloom-purple-light dark:border-bloom-dark-card py-8">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-xl bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-white font-extrabold text-xs">CB</div>
            <span class="font-extrabold text-bloom-text dark:text-white">ComicBloom</span>
        </div>
        <div class="flex gap-6 text-sm text-bloom-muted dark:text-purple-300">
            <a href="{{ route('about') }}" class="hover:text-bloom-purple transition-colors">Sobre nosotros</a>
            <a href="{{ route('contact.index') }}" class="hover:text-bloom-purple transition-colors">Contacto</a>
            <a href="{{ route('terms') }}" class="hover:text-bloom-purple transition-colors">Términos</a>
        </div>
        <p class="text-xs text-bloom-muted">© {{ date('Y') }} ComicBloom. Datos de Marvel.</p>
    </div>
</footer>

</body>
</html>
