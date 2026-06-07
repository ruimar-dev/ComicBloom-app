<x-app-layout>
    <x-slot name="title">Mi biblioteca</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-bloom-text dark:text-white mb-1">Mi biblioteca</h1>
        <p class="text-bloom-muted dark:text-purple-300">{{ $stats['all'] }} {{ $stats['all'] === 1 ? 'cómic guardado' : 'cómics guardados' }}</p>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-2 flex-wrap mb-6">
        @php
        $tabs = [
            'all'       => ['label' => 'Todos',     'count' => $stats['all'],       'color' => 'purple'],
            'unread'    => ['label' => 'Sin leer',   'count' => $stats['unread'],    'color' => 'blue'],
            'reading'   => ['label' => 'Leyendo',    'count' => $stats['reading'],   'color' => 'yellow'],
            'read'      => ['label' => 'Leídos',     'count' => $stats['read'],      'color' => 'mint'],
            'favorites' => ['label' => 'Favoritos',  'count' => $stats['favorites'], 'color' => 'pink'],
        ];
        @endphp
        @foreach ($tabs as $key => $data)
        <a href="{{ route('readingList.index', ['tab' => $key, 'sort' => $sort]) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl text-sm font-bold transition-all duration-200
               {{ $tab === $key
                   ? 'bg-bloom-purple text-white shadow-soft'
                   : 'bg-white dark:bg-bloom-dark-card text-bloom-muted dark:text-purple-200 hover:bg-bloom-purple-light hover:text-bloom-purple' }}">
            {{ $data['label'] }}
            <span class="px-2 py-0.5 rounded-full text-xs {{ $tab === $key ? 'bg-white/25' : 'bg-bloom-bgalt dark:bg-bloom-dark' }}">
                {{ $data['count'] }}
            </span>
        </a>
        @endforeach
    </div>

    {{-- Sort --}}
    <div class="flex items-center gap-3 mb-6">
        <span class="text-sm text-bloom-muted dark:text-purple-300 font-semibold">Ordenar:</span>
        @foreach (['recent' => 'Recientes', 'title' => 'Título A-Z', 'published' => 'Fecha publicación', 'status' => 'Estado'] as $key => $label)
        <a href="{{ route('readingList.index', ['tab' => $tab, 'sort' => $key]) }}"
           class="text-sm font-bold transition-colors
               {{ $sort === $key ? 'text-bloom-purple' : 'text-bloom-muted hover:text-bloom-purple' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Grid --}}
    @if ($items->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        @foreach ($items as $item)
        <div class="comic-card group relative">
            {{-- Favorite heart --}}
            <form method="POST" action="{{ route('readingList.favorite', $item->comic_id) }}"
                  class="absolute top-2 right-2 z-10">
                @csrf
                <button type="submit"
                    class="w-7 h-7 rounded-full flex items-center justify-center transition-colors shadow-card
                        {{ $item->is_favorite
                            ? 'bg-bloom-pink text-white'
                            : 'bg-white/80 text-bloom-muted hover:bg-bloom-pink hover:text-white' }}">
                    <svg class="w-4 h-4" fill="{{ $item->is_favorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </form>

            <a href="{{ route('comics.show', $item->comic_id) }}">
                @if ($item->thumbnail_url)
                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" loading="lazy">
                @else
                <div class="w-full bg-bloom-bgalt dark:bg-bloom-dark flex items-center justify-center text-bloom-muted text-xs p-8" style="aspect-ratio:2/3">
                    Sin imagen
                </div>
                @endif
            </a>

            <div class="p-3">
                <p class="text-xs font-bold text-bloom-text dark:text-white line-clamp-2 leading-tight mb-2">
                    {{ $item->title ?? 'Cómic #' . $item->comic_id }}
                </p>

                {{-- Status selector --}}
                <form method="POST" action="{{ route('readingList.update', $item->comic_id) }}" class="mb-2">
                    @csrf @method('PUT')
                    <select name="status" onchange="this.form.submit()"
                        class="w-full text-xs rounded-xl border-0 py-1.5 px-2 font-bold cursor-pointer focus:ring-2 focus:ring-bloom-purple
                            {{ match($item->status) {
                                'reading' => 'bg-bloom-yellow text-yellow-800',
                                'read'    => 'bg-bloom-mint text-green-800',
                                default   => 'bg-bloom-blue-light text-blue-700'
                            } }}">
                        <option value="unread"  {{ $item->status === 'unread'  ? 'selected' : '' }}>Sin leer</option>
                        <option value="reading" {{ $item->status === 'reading' ? 'selected' : '' }}>Leyendo</option>
                        <option value="read"    {{ $item->status === 'read'    ? 'selected' : '' }}>Leído</option>
                    </select>
                </form>

                <form method="POST" action="{{ route('readingList.destroy', $item->comic_id) }}"
                      onsubmit="return confirm('¿Quitar de tu biblioteca?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full text-xs text-bloom-muted hover:text-red-500 transition-colors py-1 font-semibold">
                        Quitar
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @else
    {{-- Empty state --}}
    <div class="empty-state">
        @if ($tab === 'favorites')
        <div class="w-20 h-20 rounded-full bg-bloom-pink-light flex items-center justify-center mb-4 text-3xl">💖</div>
        <h3 class="text-lg font-extrabold text-bloom-text dark:text-white mb-2">Sin favoritos todavía</h3>
        <p class="text-bloom-muted dark:text-purple-300 max-w-sm">Aún no tienes favoritos. Guarda los cómics que te hagan ojitos.</p>
        @elseif ($tab === 'reading')
        <div class="w-20 h-20 rounded-full bg-bloom-yellow flex items-center justify-center mb-4 text-3xl">📖</div>
        <h3 class="text-lg font-extrabold text-bloom-text dark:text-white mb-2">No estás leyendo nada</h3>
        <p class="text-bloom-muted dark:text-purple-300 max-w-sm">Marca un cómic como "Leyendo" para verlo aquí.</p>
        @elseif ($tab === 'read')
        <div class="w-20 h-20 rounded-full bg-bloom-mint flex items-center justify-center mb-4 text-3xl">✅</div>
        <h3 class="text-lg font-extrabold text-bloom-text dark:text-white mb-2">Aún no has terminado ninguno</h3>
        <p class="text-bloom-muted dark:text-purple-300 max-w-sm">Los cómics que marques como "Leído" aparecerán aquí.</p>
        @else
        <div class="w-20 h-20 rounded-full bg-bloom-purple-light flex items-center justify-center mb-4 text-3xl">✨</div>
        <h3 class="text-lg font-extrabold text-bloom-text dark:text-white mb-2">Tu biblioteca está esperando</h3>
        <p class="text-bloom-muted dark:text-purple-300 max-w-sm">Tu biblioteca está esperando su primer cómic.</p>
        @endif
        <a href="{{ route('explore') }}" class="btn-primary mt-6">Explorar cómics</a>
    </div>
    @endif

</x-app-layout>
