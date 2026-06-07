<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Términos y condiciones — ComicBloom</title>
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

<main class="max-w-3xl mx-auto px-6 py-16">
    <div class="text-center mb-10">
        <div class="w-16 h-16 rounded-full bg-bloom-bgalt dark:bg-bloom-dark-card flex items-center justify-center text-2xl mx-auto mb-4">📋</div>
        <h1 class="text-3xl font-extrabold text-bloom-text dark:text-white mb-2">Términos y condiciones</h1>
        <p class="text-bloom-muted dark:text-purple-300 text-sm">Última actualización: {{ date('d/m/Y') }}</p>
    </div>

    <div class="bg-white dark:bg-bloom-dark-alt rounded-3xl shadow-soft p-8 space-y-8 prose dark:prose-invert max-w-none">
        <section>
            <h2 class="text-lg font-extrabold text-bloom-text dark:text-white">1. Uso del servicio</h2>
            <p class="text-bloom-muted dark:text-purple-200 leading-relaxed">ComicBloom es una plataforma de descubrimiento y organización de cómics que utiliza la API oficial de Marvel. Al usar este servicio, aceptas los presentes términos y las condiciones de uso de la API de Marvel.</p>
        </section>
        <section>
            <h2 class="text-lg font-extrabold text-bloom-text dark:text-white">2. Datos de Marvel</h2>
            <p class="text-bloom-muted dark:text-purple-200 leading-relaxed">Todos los datos de cómics, personajes e imágenes son propiedad de Marvel Entertainment. ComicBloom no almacena ni distribuye contenido protegido por derechos de autor de Marvel más allá de los permisos otorgados por su API pública.</p>
        </section>
        <section>
            <h2 class="text-lg font-extrabold text-bloom-text dark:text-white">3. Cuentas de usuario</h2>
            <p class="text-bloom-muted dark:text-purple-200 leading-relaxed">Eres responsable de mantener la seguridad de tu cuenta. ComicBloom solo almacena tu lista de lectura y preferencias personales. No compartimos tus datos con terceros.</p>
        </section>
        <section>
            <h2 class="text-lg font-extrabold text-bloom-text dark:text-white">4. Limitación de responsabilidad</h2>
            <p class="text-bloom-muted dark:text-purple-200 leading-relaxed">ComicBloom se proporciona "tal cual" sin garantías de disponibilidad continua. No somos responsables de interrupciones en la API de Marvel ni de cambios en su catálogo.</p>
        </section>
        <section>
            <h2 class="text-lg font-extrabold text-bloom-text dark:text-white">5. Contacto</h2>
            <p class="text-bloom-muted dark:text-purple-200 leading-relaxed">Para cualquier consulta sobre estos términos, puedes contactarnos a través del <a href="{{ route('contact.index') }}" class="text-bloom-purple hover:underline font-bold">formulario de contacto</a>.</p>
        </section>
    </div>
</main>

</body>
</html>
