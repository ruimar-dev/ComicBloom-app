<x-app-layout>
    <x-slot name="title">Explorar</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-extrabold text-bloom-text dark:text-white mb-2">Explorar cómics</h1>
        <p class="text-bloom-muted dark:text-purple-300">Busca por título, personaje o serie</p>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('explore') }}" class="mb-8" id="search-form">
        <div class="relative max-w-2xl">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-bloom-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ $query }}" id="search-input"
                   placeholder="Spider-Man, Iron Man, X-Men, Hulk..."
                   class="input-cute pl-12 pr-24 py-4 text-base shadow-soft w-full"
                   autocomplete="off">
            <button type="submit"
                class="absolute right-2 top-1/2 -translate-y-1/2 btn-primary py-2 px-4 text-sm">
                Buscar
            </button>
        </div>
        @if (!$query)
        <div class="flex flex-wrap gap-2 mt-3">
            @foreach (['Spider-Man', 'Iron Man', 'Thor', 'Black Panther', 'Captain America', 'Wolverine'] as $suggestion)
            <a href="{{ route('explore', ['search' => $suggestion]) }}"
               class="px-3 py-1.5 bg-white dark:bg-bloom-dark-card border border-bloom-purple-light dark:border-bloom-dark text-bloom-purple text-xs font-bold rounded-full hover:bg-bloom-purple hover:text-white transition-colors">
                {{ $suggestion }}
            </a>
            @endforeach
        </div>
        @endif
    </form>

    {{-- Results count --}}
    @if ($query)
    <p class="text-sm text-bloom-muted dark:text-purple-300 mb-6">
        {{ $total > 0 ? number_format($total) . ' resultados para "' . $query . '"' : 'Sin resultados para "' . $query . '"' }}
    </p>
    @endif

    {{-- Grid --}}
    @if (count($comics) > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4" id="comics-grid">
        @foreach ($comics as $comic)
        <div class="comic-card">
            <a href="{{ route('comics.show', $comic['id']) }}">
                <img src="{{ $comic['thumbnail_url'] }}"
                     alt="{{ $comic['title'] }}"
                     loading="lazy">
            </a>
            <div class="p-3">
                <p class="text-xs font-bold text-bloom-text dark:text-white line-clamp-2 leading-tight mb-2">{{ $comic['title'] }}</p>
                @if (!empty($comic['cover_date']))
                <p class="text-xs text-bloom-muted mb-2">{{ \Carbon\Carbon::parse($comic['cover_date'])->format('Y') }}</p>
                @endif
                @auth
                <form method="POST" action="{{ route('readingList.add') }}">
                    @csrf
                    <input type="hidden" name="comic_id" value="{{ $comic['id'] }}">
                    <button type="submit"
                        class="w-full py-1.5 rounded-xl text-xs font-bold bg-bloom-purple-light dark:bg-bloom-dark text-bloom-purple hover:bg-bloom-purple hover:text-white transition-colors">
                        + Biblioteca
                    </button>
                </form>
                @endauth
            </div>
        </div>
        @endforeach
    </div>

    {{-- Load more --}}
    @if ($total > count($comics) + $offset)
    <div class="flex justify-center mt-10">
        <a href="{{ route('explore', ['search' => $query, 'offset' => $offset + 24]) }}"
           class="btn-secondary">
            Cargar más
        </a>
    </div>
    @endif

    @elseif ($query)
    <div class="empty-state">
        <div class="w-20 h-20 rounded-full bg-bloom-bgalt dark:bg-bloom-dark-card flex items-center justify-center mb-4 text-3xl">🕷️</div>
        <h3 class="text-lg font-extrabold text-bloom-text dark:text-white mb-2">Sin resultados</h3>
        <p class="text-bloom-muted dark:text-purple-300 max-w-sm">
            No encontramos cómics con "{{ $query }}". Prueba con Spider-Man, Iron Man o X-Men.
        </p>
        <a href="{{ route('explore') }}" class="btn-primary mt-6">Ver todos los cómics</a>
    </div>
    @endif

</x-app-layout>
