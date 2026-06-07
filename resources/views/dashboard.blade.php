<x-app-layout>
    <x-slot name="title">Inicio</x-slot>

    {{-- Greeting --}}
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-extrabold text-bloom-text dark:text-white">
            Hola, {{ auth()->user()->name }} 👋
        </h1>
        <p class="text-bloom-muted dark:text-purple-300 mt-1">¿Qué cómic vas a descubrir hoy?</p>
    </div>

    @if (!$apiConfigured)
    <div class="mb-8 p-4 bg-bloom-yellow/30 border border-yellow-200 dark:border-yellow-700 rounded-2xl">
        <p class="font-bold text-yellow-800 dark:text-yellow-200">⚠️ API no configurada</p>
        <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
            Regístrate gratis en
            <a href="https://comicvine.gamespot.com/api/" target="_blank" class="underline font-bold">comicvine.gamespot.com/api</a>
            y añade tu clave en <code class="bg-yellow-100 dark:bg-yellow-900 px-1 rounded">.env</code> como
            <code class="bg-yellow-100 dark:bg-yellow-900 px-1 rounded">COMICVINE_API_KEY=tu_clave</code>.
        </p>
    </div>
    @endif

    {{-- Search bar --}}
    <div class="mb-10">
        <form action="{{ route('explore') }}" method="GET">
            <div class="relative max-w-xl">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-bloom-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" placeholder="Busca Spider-Man, Iron Man, X-Men..."
                    class="input-cute pl-12 pr-4 py-3.5 text-base shadow-soft">
            </div>
        </form>
    </div>

    {{-- Continúa leyendo --}}
    @if ($inProgress->count() > 0)
    <section class="mb-10">
        <div class="section-title">
            <span class="w-2 h-6 bg-bloom-pink rounded-full inline-block"></span>
            Continúa leyendo
        </div>
        <div class="carousel-scroll">
            @foreach ($inProgress as $item)
            <a href="{{ route('comics.show', $item->comic_id) }}"
               class="flex-none w-28 md:w-36 comic-card">
                @if ($item->thumbnail_url)
                    <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}">
                @else
                    <div class="w-full bg-bloom-bgalt dark:bg-bloom-dark-card flex items-center justify-center text-bloom-muted text-xs p-4" style="aspect-ratio:2/3">Sin imagen</div>
                @endif
                <div class="p-2">
                    <p class="text-xs font-bold text-bloom-text dark:text-white line-clamp-2 leading-tight">{{ $item->title }}</p>
                    <span class="status-badge status-reading mt-1">Leyendo</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Tendencias --}}
    <section class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div class="section-title mb-0">
                <span class="w-2 h-6 bg-bloom-purple rounded-full inline-block"></span>
                Tendencias Marvel
            </div>
            <a href="{{ route('explore') }}" class="text-sm font-bold text-bloom-purple hover:underline">Ver todo</a>
        </div>
        <div class="carousel-scroll">
            @forelse ($trending as $comic)
            <div class="flex-none w-36 md:w-44 comic-card">
                <a href="{{ route('comics.show', $comic['id']) }}">
                    <img src="{{ $comic['thumbnail_url'] }}" alt="{{ $comic['title'] }}">
                </a>
                <div class="p-3">
                    <p class="text-xs font-bold text-bloom-text dark:text-white line-clamp-2 leading-tight mb-2">{{ $comic['title'] }}</p>
                    <div class="flex items-center gap-1.5">
                        <form method="POST" action="{{ route('readingList.add') }}">
                            @csrf
                            <input type="hidden" name="comic_id" value="{{ $comic['id'] }}">
                            <button type="submit" title="Añadir a biblioteca"
                                class="w-7 h-7 rounded-xl bg-bloom-purple-light dark:bg-bloom-dark hover:bg-bloom-purple hover:text-white text-bloom-purple flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </form>
                        <a href="{{ route('comics.show', $comic['id']) }}"
                           class="flex-1 text-center text-xs font-bold text-bloom-purple hover:underline">Ver</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state w-full py-8">
                <p class="text-bloom-muted">{{ $apiConfigured ? 'No se pudieron cargar los cómics.' : 'Configura tu API key de ComicVine para ver cómics.' }}</p>
            </div>
            @endforelse
        </div>
    </section>

    {{-- Descubre --}}
    <section class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div class="section-title mb-0">
                <span class="w-2 h-6 bg-bloom-mint rounded-full inline-block"></span>
                Descubre algo nuevo
            </div>
            <a href="{{ route('explore') }}" class="text-sm font-bold text-bloom-purple hover:underline">Ver todo</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse ($recent as $comic)
            <div class="comic-card">
                <a href="{{ route('comics.show', $comic['id']) }}">
                    <img src="{{ $comic['thumbnail_url'] }}" alt="{{ $comic['title'] }}">
                </a>
                <div class="p-3">
                    <p class="text-xs font-bold text-bloom-text dark:text-white line-clamp-2 leading-tight mb-2">{{ $comic['title'] }}</p>
                    <form method="POST" action="{{ route('readingList.add') }}">
                        @csrf
                        <input type="hidden" name="comic_id" value="{{ $comic['id'] }}">
                        <button type="submit"
                            class="w-full py-1.5 rounded-xl text-xs font-bold bg-bloom-purple-light dark:bg-bloom-dark text-bloom-purple hover:bg-bloom-purple hover:text-white transition-colors">
                            + Biblioteca
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-bloom-muted col-span-full text-center py-8">No se pudieron cargar los cómics.</p>
            @endforelse
        </div>
    </section>

</x-app-layout>
