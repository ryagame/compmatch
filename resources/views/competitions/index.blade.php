{{-- resources/views/competitions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Lomba - CompMatch')

@section('content')

{{-- ===== HERO ===== --}}
<section class="cm-hero">
    <div class="cm-hero-bg"></div>
    <div class="cm-hero-grid"></div>
    <div class="cm-hero-inner">

        <div class="cm-badge">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            Compmatch Platform
        </div>

        <h1 class="cm-hero-title">
            Temukan Lomba dan<br>
            <em>Bangun Tim</em> Terbaikmu
        </h1>

        <p class="cm-hero-desc">
            Cari kompetisi, buat lobby tim, isi role spesifik, dan temukan rekan setim
            yang tepat untuk memenangkan kompetisi bersama.
        </p>

        <div class="cm-hero-actions">
            <a href="{{ route('competitions.create') }}" class="cm-btn-primary">
                Mulai Posting Lomba
            </a>
            <a href="#daftar-lomba" class="cm-btn-outline">Jelajahi Lomba →</a>
        </div>

        <div class="cm-stats">
            <div class="cm-stat">
                <div class="cm-stat-value">{{ $totalCompetitions }}</div>
                <div class="cm-stat-label">Lomba Aktif</div>
            </div>
            <div class="cm-stat">
                <div class="cm-stat-value">{{ $totalUsers }}</div>
                <div class="cm-stat-label">Peserta Terdaftar</div>
            </div>
            <div class="cm-stat">
                <div class="cm-stat-value">93%</div>
                <div class="cm-stat-label">Kepuasan Tim</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== SEARCH + LIST ===== --}}
<section class="cm-section" id="daftar-lomba">

    {{-- Search Bar --}}
    <form method="GET" action="{{ route('competitions.index') }}" class="cm-search-bar">
        <svg class="cm-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari kompetisi berdasarkan nama...">
        <select name="kategori">
    <option value="">Semua Kategori</option>
    <option value="desain"    {{ request('kategori') == 'desain'    ? 'selected' : '' }}>Desain</option>
    <option value="teknologi" {{ request('kategori') == 'teknologi' ? 'selected' : '' }}>Teknologi</option>
    <option value="bisnis"    {{ request('kategori') == 'bisnis'    ? 'selected' : '' }}>Bisnis</option>
    <option value="seni"      {{ request('kategori') == 'seni'      ? 'selected' : '' }}>Seni</option>
    </select>
        <button type="submit">CARI</button>
    </form>

    {{-- Filter Chips --}}
    <div class="cm-filter-chips">
        <a href="{{ route('competitions.index') }}"
           class="cm-chip {{ !request('kategori') && !request('sort') ? 'active' : '' }}">
           Semua
        </a>
        @foreach(['desain','teknologi','bisnis','seni'] as $kat)
        <a href="{{ route('competitions.index', ['kategori' => $kat]) }}"
           class="cm-chip {{ request('kategori') == $kat ? 'active' : '' }}">
           {{ ucfirst($kat) }}
        </a>
        @endforeach
        <a href="{{ route('competitions.index', array_merge(request()->except('sort'), ['sort' => 'deadline'])) }}"
           class="cm-chip {{ request('sort') == 'deadline' ? 'active' : '' }}">
           Deadline Terdekat
        </a>
        <a href="{{ route('competitions.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}"
           class="cm-chip {{ request('sort') == 'latest' ? 'active' : '' }}">
           Terbaru
        </a>
    </div>

    {{-- Section Header --}}
    <div class="cm-section-header">
        <span class="cm-section-title">Daftar Lomba</span>
        <span class="cm-section-count">{{ $competitions->total() }} kompetisi ditemukan</span>
    </div>

    {{-- Cards Grid --}}
    <div class="cm-cards-grid">
        @forelse($competitions as $comp)
        <div class="cm-card">

            {{-- Thumbnail --}}
            <div class="cm-card-thumb cm-card-thumb-{{ strtolower($comp->kategori ?? 'default') }}">
                @if($comp->thumbnail)
                    <img src="{{ asset('storage/' . $comp->thumbnail) }}"
                         alt="{{ $comp->nama }}"
                         style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div class="cm-card-thumb-icon">
                        {{ strtoupper(substr($comp->nama, 0, 4)) }}
                    </div>
                @endif
            </div>

            {{-- Body --}}
            <div class="cm-card-body">
                <span class="cm-tag cm-tag-{{ strtolower($comp->kategori ?? 'default') }}">
                    {{ $comp->kategori ?? 'Umum' }}
                </span>

                <div class="cm-card-title">{{ $comp->nama }}</div>
                <div class="cm-card-desc">{{ Str::limit($comp->deskripsi, 85) }}</div>

                <div class="cm-card-meta">
                    <div class="cm-deadline">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        DL: {{ \Carbon\Carbon::parse($comp->deadline)->format('Y-m-d') }}
                    </div>
                    <div class="cm-poster">
                        <span>Oleh</span>
                        <strong>{{ strtoupper(Str::limit($comp->user->name ?? 'Unknown', 18)) }}</strong>
                    </div>
                </div>

                <div class="cm-card-actions">
                    <a href="{{ route('competitions.show', $comp->id) }}" class="cm-btn-detail">
                        Lihat Detail
                    </a>

                    @auth
                    @if(Auth::id() === $comp->user_id)
                        <a href="{{ route('competitions.edit', $comp->id) }}"
                           class="cm-btn-icon" title="Edit">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </a>

                        <form method="POST" action="{{ route('competitions.destroy', $comp->id) }}"
                              onsubmit="return confirm('Yakin hapus lomba ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cm-btn-icon danger" title="Hapus">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                    @endauth
                </div>
            </div>
        </div>

        @empty
        <div class="cm-empty">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <p>Tidak ada kompetisi ditemukan.</p>
            <a href="{{ route('competitions.create') }}" class="cm-btn-primary">+ Tambah Lomba Pertama</a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($competitions->hasPages())
    <div class="cm-pagination">
        {{ $competitions->withQueryString()->links() }}
    </div>
    @endif

</section>

@endsection