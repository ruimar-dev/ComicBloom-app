<x-app-layout>
    <x-slot name="title">{{ $comic['title'] }}</x-slot>

    <div class="max-w-4xl mx-auto">
        {{-- Back --}}
        <a href="javascript:history.back()" class="inline-flex items-center gap-2 text-bloom-muted hover:text-bloom-purple font-semibold text-sm mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Volver
        </a>

        <div class="flex flex-col md:flex-row gap-8">
            {{-- Cover --}}
            <div class="flex-none">
                <div class="w-48 md:w-56 mx-auto md:mx-0 rounded-3xl overflow-hidden shadow-soft-lg">
                    <img src="{{ $comic['large_url'] ?? $comic['thumbnail_url'] }}"
                         alt="{{ $comic['title'] }}"
                         class="w-full">
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <h1 class="text-2xl md:text-3xl font-extrabold text-bloom-text dark:text-white leading-tight mb-3">
                    {{ $comic['title'] }}
                </h1>

                {{-- Meta --}}
                <div class="flex flex-wrap gap-3 mb-4">
                    @if (!empty($comic['cover_date']))
                    <span class="status-badge bg-bloom-yellow text-yellow-800">
                        {{ \Carbon\Carbon::parse($comic['cover_date'])->format('d M Y') }}
                    </span>
                    @endif
                    @if (!empty($comic['volume_name']))
                    <span class="status-badge bg-bloom-blue-light text-blue-700">{{ $comic['volume_name'] }}</span>
                    @endif
                    @if ($inLibrary)
                    <span class="status-badge status-{{ $inLibrary->status }}">
                        {{ match($inLibrary->status) { 'unread' => 'Sin leer', 'reading' => 'Leyendo', 'read' => 'Leído', default => '' } }}
                    </span>
                    @endif
                </div>

                {{-- Description --}}
                @if (!empty($comic['description']))
                <p class="text-bloom-muted dark:text-purple-200 leading-relaxed mb-6">{{ $comic['description'] }}</p>
                @else
                <p class="text-bloom-muted dark:text-purple-300 italic mb-6">Sin descripción disponible.</p>
                @endif

                {{-- Actions --}}
                @auth
                <div class="flex flex-wrap gap-3 mb-6">
                    @if (!$inLibrary)
                    <form method="POST" action="{{ route('readingList.add') }}">
                        @csrf
                        <input type="hidden" name="comic_id" value="{{ $comic['id'] }}">
                        <button type="submit" class="btn-primary">+ Añadir a biblioteca</button>
                    </form>
                    @else
                    <div class="flex gap-2 flex-wrap">
                        @foreach (['unread' => 'Sin leer', 'reading' => 'Leyendo', 'read' => 'Leído'] as $status => $label)
                        <form method="POST" action="{{ route('readingList.update', $comic['id']) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="{{ $status }}">
                            <button type="submit"
                                class="px-4 py-2 rounded-2xl text-sm font-bold transition-colors
                                    {{ $inLibrary->status === $status
                                        ? 'bg-bloom-purple text-white'
                                        : 'bg-bloom-purple-light dark:bg-bloom-dark-card text-bloom-purple hover:bg-bloom-purple hover:text-white' }}">
                                {{ $label }}
                            </button>
                        </form>
                        @endforeach
                    </div>

                    <form method="POST" action="{{ route('readingList.favorite', $comic['id']) }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-2xl text-sm font-bold transition-colors
                                {{ $inLibrary->is_favorite
                                    ? 'bg-bloom-pink text-white'
                                    : 'bg-bloom-pink-light text-bloom-pink hover:bg-bloom-pink hover:text-white' }}">
                            {{ $inLibrary->is_favorite ? '♥ Favorito' : '♡ Favorito' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('readingList.destroy', $comic['id']) }}"
                          onsubmit="return confirm('¿Quitar de tu biblioteca?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-2xl text-sm font-bold bg-red-50 dark:bg-red-900/20 text-red-500 hover:bg-red-100 transition-colors">
                            Quitar
                        </button>
                    </form>
                    @endif
                </div>
                @else
                <div class="mb-6">
                    <a href="{{ route('login') }}" class="btn-primary inline-block">Inicia sesión para guardar</a>
                </div>
                @endauth

                {{-- ComicVine link --}}
                @if (!empty($comic['site_url']))
                <a href="{{ $comic['site_url'] }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 text-sm text-bloom-muted hover:text-bloom-purple font-semibold transition-colors mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Ver en ComicVine
                </a>
                @endif

                {{-- Characters --}}
                @if (!empty($comic['characters']))
                <div class="mb-4">
                    <h3 class="text-sm font-extrabold text-bloom-text dark:text-white uppercase tracking-wider mb-2">Personajes</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($comic['characters'] as $char)
                        <span class="px-3 py-1 bg-bloom-bgalt dark:bg-bloom-dark-card rounded-full text-xs font-semibold text-bloom-muted dark:text-purple-200">{{ $char['name'] }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Creators --}}
                @if (!empty($comic['creators']))
                <div>
                    <h3 class="text-sm font-extrabold text-bloom-text dark:text-white uppercase tracking-wider mb-2">Equipo creativo</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($comic['creators'] as $creator)
                        <span class="px-3 py-1 bg-bloom-purple-light dark:bg-bloom-dark-card rounded-full text-xs font-semibold text-bloom-purple dark:text-purple-200">
                            {{ $creator['name'] }}@if (!empty($creator['role'])) <span class="opacity-60">· {{ $creator['role'] }}</span>@endif
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Related --}}
        @if (!empty($related))
        <section class="mt-12">
            <div class="section-title">
                <span class="w-2 h-6 bg-bloom-blue rounded-full inline-block"></span>
                También te puede interesar
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($related as $rel)
                @if ($rel['id'] !== $comic['id'])
                <div class="comic-card">
                    <a href="{{ route('comics.show', $rel['id']) }}">
                        <img src="{{ $rel['thumbnail_url'] }}" alt="{{ $rel['title'] }}" loading="lazy">
                    </a>
                    <div class="p-2">
                        <p class="text-xs font-bold text-bloom-text dark:text-white line-clamp-2 leading-tight">{{ $rel['title'] }}</p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </section>
        @endif
    </div>
</x-app-layout>
