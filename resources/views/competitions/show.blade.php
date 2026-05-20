@extends('layouts.app')

@section('title', $competition->nama . ' - CompMatch')

@section('content')

<div class="min-h-screen bg-[#070711] text-white">

    {{-- HERO --}}
    <section class="relative overflow-hidden border-b border-white/5">

        {{-- background image --}}
        @if($competition->thumbnail)
            <div class="absolute inset-0">
                <img
                    src="{{ asset('storage/' . $competition->thumbnail) }}"
                    class="w-full h-full object-cover opacity-20"
                    alt="{{ $competition->nama }}"
                >
            </div>
        @endif

        {{-- overlay --}}
        <div class="absolute inset-0 bg-gradient-to-b from-[#080812]/60 via-[#070711] to-[#070711]"></div>

        <div class="relative max-w-7xl mx-auto px-6 py-20">

            <a href="{{ route('competitions.index') }}"
               class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition mb-10">
                ← Kembali ke daftar lomba
            </a>

            <div class="grid lg:grid-cols-2 gap-12 items-center">

                {{-- LEFT --}}
                <div>

                    <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-bold uppercase tracking-[0.2em] mb-6">
                        {{ $competition->kategori }}
                    </span>

                    <h1 class="text-5xl lg:text-6xl font-black leading-tight tracking-tight mb-6">
                        {{ $competition->nama }}
                    </h1>

                    <p class="text-slate-400 text-lg leading-relaxed mb-8">
                        {{ $competition->deskripsi }}
                    </p>

                    <div class="flex flex-wrap gap-4">

                        <div class="bg-white/5 border border-white/5 rounded-2xl px-5 py-4 min-w-[220px]">
                            <div class="text-slate-500 text-xs uppercase tracking-widest mb-2">
                                Penyelenggara
                            </div>

                            <div class="font-bold text-lg">
                                {{ $competition->user->name }}
                            </div>
                        </div>

                        <div class="bg-rose-500/10 border border-rose-500/10 rounded-2xl px-5 py-4 min-w-[220px]">
                            <div class="text-rose-300/70 text-xs uppercase tracking-widest mb-2">
                                Deadline
                            </div>

                            <div class="font-bold text-lg text-rose-300">
                                {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}
                            </div>
                        </div>

                    </div>

                    @if(Auth::id() === $competition->user_id)

                        <div class="flex flex-wrap gap-3 mt-8">

                            <a href="{{ route('competitions.edit', $competition->id) }}"
                               class="bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-2xl text-sm font-bold transition">
                                Edit Kompetisi
                            </a>

                            <form method="POST"
                                  action="{{ route('competitions.destroy', $competition->id) }}"
                                  onsubmit="return confirm('Hapus kompetisi ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="bg-white/5 border border-white/10 hover:bg-rose-600 hover:border-rose-600 px-6 py-3 rounded-2xl text-sm font-bold transition">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    @endif

                </div>

                {{-- RIGHT --}}
                <div>

                    <div class="bg-gradient-to-br from-indigo-500/20 to-purple-500/10 border border-white/10 rounded-[32px] p-5 shadow-2xl">

                        @if($competition->thumbnail)

                            <img
                                src="{{ asset('storage/' . $competition->thumbnail) }}"
                                alt="{{ $competition->nama }}"
                                class="w-full h-[420px] object-cover rounded-3xl"
                            >

                        @else

                            <div class="h-[420px] rounded-3xl bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center">

                                <div class="text-center">

                                    <div class="text-7xl font-black tracking-tight">
                                        {{ strtoupper(substr($competition->nama, 0, 2)) }}
                                    </div>

                                    <div class="mt-4 text-indigo-100 uppercase tracking-[0.3em] text-sm">
                                        COMPMATCH
                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- LOBBY --}}
    <section class="max-w-7xl mx-auto px-6 py-16">

        <div class="flex flex-wrap justify-between items-center gap-5 mb-10">

            <div>
                <h2 class="text-3xl font-black tracking-tight mb-2">
                    Lobby Tim
                </h2>

                <p class="text-slate-400">
                    Temukan tim terbaik dan mulai kolaborasi.
                </p>
            </div>

            <a href="{{ url('/competitions/'.$competition->id.'/lobbies/create') }}"
               class="bg-emerald-600 hover:bg-emerald-700 px-6 py-3 rounded-2xl text-sm font-bold transition shadow-lg shadow-emerald-900/30">
                + Buat Lobby
            </a>

        </div>

        @if($competition->lobbies->count() > 0)

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach($competition->lobbies as $lobby)

                    <div class="bg-[#11111d] border border-white/5 hover:border-indigo-500/20 rounded-3xl p-6 transition duration-300">

                        <div class="flex justify-between items-start mb-5">

                            <div>
                                <h3 class="text-xl font-bold mb-2">
                                    {{ $lobby->name }}
                                </h3>

                                <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-300 text-[11px] uppercase tracking-widest font-bold">
                                    {{ $lobby->status ?? 'Tersedia' }}
                                </span>
                            </div>

                        </div>

                        <div class="space-y-4 text-slate-400 mb-8">

                            <div class="flex justify-between">
                                <span>Jumlah Anggota</span>
                                <strong class="text-white">
                                    {{ $lobby->members_count ?? 0 }}/{{ $lobby->max_members ?? 4 }}
                                </strong>
                            </div>

                            <div class="flex justify-between">
                                <span>Skill Dibutuhkan</span>
                                <strong class="text-indigo-300">
                                    {{ $lobby->skill_slots_count ?? 0 }}
                                </strong>
                            </div>

                        </div>

                        <a href="{{ route('competitions.lobbies.show', [$competition->id, $lobby->id]) }}"
                           class="block text-center bg-indigo-600 hover:bg-indigo-700 rounded-2xl py-3 font-bold transition">
                            Lihat Detail Tim
                        </a>

                    </div>

                @endforeach

            </div>

        @else

            <div class="bg-[#11111d] border border-dashed border-white/10 rounded-[32px] py-24 text-center">

                <div class="text-6xl mb-6">
                    🚀
                </div>

                <h3 class="text-2xl font-bold mb-3">
                    Belum Ada Lobby
                </h3>

                <p class="text-slate-500 mb-8">
                    Jadilah yang pertama membuat tim untuk kompetisi ini.
                </p>

                <a href="{{ url('/competitions/'.$competition->id.'/lobbies/create') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 px-7 py-3 rounded-2xl font-bold transition">
                    + Buat Lobby Pertama
                </a>

            </div>

        @endif

    </section>

</div>

@endsection