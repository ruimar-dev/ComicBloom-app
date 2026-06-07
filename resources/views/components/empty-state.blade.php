@props(['icon' => 'book', 'message' => 'Sin resultados', 'action' => null, 'actionLabel' => 'Explorar'])

<div class="empty-state">
    <div class="w-20 h-20 rounded-full bg-bloom-purple-light dark:bg-bloom-dark-card flex items-center justify-center mb-4 text-3xl">
        @if ($icon === 'heart') 💖
        @elseif ($icon === 'book') 📚
        @elseif ($icon === 'search') 🔍
        @else ✨
        @endif
    </div>
    <p class="text-bloom-muted dark:text-purple-300 max-w-sm text-center">{{ $message }}</p>
    @if ($action)
    <a href="{{ $action }}" class="btn-primary mt-6">{{ $actionLabel }}</a>
    @endif
</div>
