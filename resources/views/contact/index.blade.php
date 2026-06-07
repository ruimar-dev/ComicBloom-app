<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacto — ComicBloom</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-bloom-bg dark:bg-bloom-dark min-h-screen">

{{-- Nav --}}
<nav class="sticky top-0 z-50 bg-white/80 dark:bg-bloom-dark-alt/80 backdrop-blur-md border-b border-bloom-purple-light dark:border-bloom-dark-card">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('welcome') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-white font-extrabold text-sm">CB</div>
            <span class="font-extrabold text-bloom-text dark:text-white text-lg">ComicBloom</span>
        </a>
        <a href="{{ route('welcome') }}" class="text-sm font-bold text-bloom-muted hover:text-bloom-purple transition-colors">← Volver</a>
    </div>
</nav>

<main class="max-w-2xl mx-auto px-6 py-16">
    <div class="text-center mb-10">
        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-2xl mx-auto mb-4">💌</div>
        <h1 class="text-3xl font-extrabold text-bloom-text dark:text-white mb-2">Contacto</h1>
        <p class="text-bloom-muted dark:text-purple-300">¿Tienes alguna pregunta? Estamos aquí para ayudarte.</p>
    </div>

    @if (session('success'))
    <div class="bg-bloom-mint/40 border border-green-200 rounded-2xl p-4 mb-6 text-center">
        <p class="font-bold text-green-800">¡Mensaje enviado! Te responderemos pronto.</p>
    </div>
    @endif

    <div class="bg-white dark:bg-bloom-dark-alt rounded-3xl shadow-soft p-8">
        <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-bold text-bloom-text dark:text-white mb-1.5">Nombre</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="input-cute @error('name') border-red-400 @enderror"
                    placeholder="Tu nombre">
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-bold text-bloom-text dark:text-white mb-1.5">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="input-cute @error('email') border-red-400 @enderror"
                    placeholder="tu@email.com">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="message" class="block text-sm font-bold text-bloom-text dark:text-white mb-1.5">Mensaje</label>
                <textarea id="message" name="message" rows="5" required
                    class="input-cute resize-none @error('message') border-red-400 @enderror"
                    placeholder="Cuéntanos en qué podemos ayudarte...">{{ old('message') }}</textarea>
                @error('message')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn-pink w-full py-3 text-base">Enviar mensaje</button>
        </form>
    </div>
</main>

</body>
</html>
