<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ComicBloom') }} — {{ $title ?? 'Descubre cómics' }}</title>
    <link rel="icon" href="{{ asset('img/mobile-logo-claro.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-bloom-bg dark:bg-bloom-dark min-h-screen">

<x-banner />

{{-- Sidebar desktop --}}
<aside class="sidebar hidden md:flex flex-col" id="sidebar">
    <div class="p-5 border-b border-bloom-purple-light dark:border-bloom-dark-card">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-white font-extrabold text-sm">CB</div>
            <span class="font-extrabold text-bloom-text dark:text-white text-lg">ComicBloom</span>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto p-3 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Inicio
        </a>
        <a href="{{ route('explore') }}"
           class="sidebar-link {{ request()->routeIs('explore') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Explorar
        </a>
        <a href="{{ route('readingList.index') }}"
           class="sidebar-link {{ request()->routeIs('readingList.*') && request('tab') !== 'favorites' ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Mi biblioteca
        </a>
        <a href="{{ route('readingList.index', ['tab' => 'favorites']) }}"
           class="sidebar-link {{ request()->routeIs('readingList.*') && request('tab') === 'favorites' ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            Favoritos
        </a>
        <a href="{{ route('readingList.index', ['tab' => 'reading']) }}"
           class="sidebar-link">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Leyendo ahora
        </a>

        <div class="pt-3 pb-1 px-2">
            <span class="text-xs font-bold text-bloom-muted uppercase tracking-wider">Cuenta</span>
        </div>
        <a href="{{ route('profile.show') }}"
           class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Perfil
        </a>
    </nav>

    <div class="p-4 border-t border-bloom-purple-light dark:border-bloom-dark-card">
        <div class="flex items-center gap-3">
            @if (auth()->user()?->profile_photo_url)
                <img src="{{ auth()->user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
            @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-bloom-text dark:text-white truncate">{{ auth()->user()?->name }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-bloom-muted hover:text-bloom-pink transition-colors" title="Cerrar sesión">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Main content --}}
<div class="md:ml-64 min-h-screen flex flex-col">
    {{-- Top header mobile --}}
    <header class="md:hidden sticky top-0 z-30 bg-white dark:bg-bloom-dark-alt border-b border-bloom-purple-light dark:border-bloom-dark-card px-4 py-3 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-xl bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-white font-extrabold text-xs">CB</div>
            <span class="font-extrabold text-bloom-text dark:text-white">ComicBloom</span>
        </a>
        <a href="{{ route('profile.show') }}">
            @if (auth()->user()?->profile_photo_url)
                <img src="{{ auth()->user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
            @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-bloom-pink to-bloom-purple flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
            @endif
        </a>
    </header>

    {{-- Page content --}}
    <main class="flex-1 p-4 md:p-8 pb-24 md:pb-8">
        {{ $slot }}
    </main>
</div>

{{-- Mobile bottom nav --}}
<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Inicio
    </a>
    <a href="{{ route('explore') }}" class="bottom-nav-item {{ request()->routeIs('explore') ? 'active' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        Buscar
    </a>
    <a href="{{ route('readingList.index') }}" class="bottom-nav-item {{ request()->routeIs('readingList.*') ? 'active' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        Biblioteca
    </a>
    <a href="{{ route('readingList.index', ['tab' => 'favorites']) }}" class="bottom-nav-item {{ request('tab') === 'favorites' ? 'active' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        Favoritos
    </a>
    <a href="{{ route('profile.show') }}" class="bottom-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Perfil
    </a>
</nav>

@stack('modals')
@livewireScripts
</body>
</html>
