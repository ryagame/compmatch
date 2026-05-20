{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'CompMatch'))</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">

    {{-- Vite: CSS + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="cm-nav">
        <a href="{{ route('competitions.index') }}" class="cm-logo">comp<span>match</span></a>

        <div class="cm-nav-links">
            <a href="{{ route('competitions.index') }}"
               class="{{ request()->routeIs('competitions.*') ? 'active' : '' }}">
               Lomba
            </a>
            <a href="#">Tim Saya</a>
            <a href="#">Leaderboard</a>
        </div>

        <div class="cm-nav-right">
            @auth
                <span class="cm-nav-user">{{ Auth::user()->name }}</span>
            @endauth
            <a href="{{ route('competitions.create') }}" class="cm-btn-primary">+ Tambah Lomba</a>
        </div>
    </nav>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="cm-alert cm-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="cm-alert cm-alert-error">{{ session('error') }}</div>
    @endif

    {{-- PAGE CONTENT --}}
    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>