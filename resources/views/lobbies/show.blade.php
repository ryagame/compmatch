@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#0b0b14] text-white relative overflow-hidden">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute top-0 left-0 w-full h-[300px] bg-gradient-to-b from-indigo-500/10 to-transparent blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-6 py-12 relative z-10 space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            <div>
                <h1 class="text-4xl font-bold tracking-tight mb-2">
                    {{ $lobby->name }}
                </h1>

                <p class="text-slate-400 text-[15px]">
                    Kelola anggota tim dan skill yang dibutuhkan.
                </p>
            </div>

            @if($isOwner)

                <div class="flex flex-wrap gap-3">

                    {{-- MATCHMAKING --}}
                    <form action="{{ route('competitions.lobbies.matchmaking', [$lobby->competition_id, $lobby->id]) }}"
                          method="POST"
                          onsubmit="return confirm('Jalankan matchmaking otomatis?')">

                        @csrf

                        <button
                            class="bg-indigo-500 hover:bg-indigo-400 transition-all duration-300 px-5 py-3 rounded-2xl text-sm font-semibold">
                            Matchmaking
                        </button>

                    </form>

                    {{-- RESET --}}
                    <form action="{{ route('competitions.lobbies.resetMatchmaking', [$lobby->competition_id, $lobby->id]) }}"
                          method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="bg-white/5 hover:bg-white/10 border border-white/10 transition-all duration-300 px-5 py-3 rounded-2xl text-sm font-semibold">
                            Reset
                        </button>

                    </form>

                    {{-- EDIT --}}
                    <a href="{{ route('competitions.lobbies.edit', [$competition, $lobby]) }}"
                       class="bg-white/5 hover:bg-white/10 border border-white/10 transition-all duration-300 px-5 py-3 rounded-2xl text-sm font-semibold">
                        Edit
                    </a>

                    {{-- DELETE --}}
                    <form action="{{ route('competitions.lobbies.destroy', [$competition, $lobby]) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus lobby ini?')">

                        @csrf
                        @method('DELETE')

                        <button
                            class="bg-rose-500/90 hover:bg-rose-500 transition-all duration-300 px-5 py-3 rounded-2xl text-sm font-semibold">
                            Hapus
                        </button>

                    </form>

                </div>

            @endif

        </div>

        {{-- ALERT --}}
        @if(session('success'))

            <div class="bg-emerald-500/10 border border-emerald-500/10 text-emerald-300 px-5 py-4 rounded-2xl">
                {{ session('success') }}
            </div>

        @endif

        @if(session('error'))

            <div class="bg-rose-500/10 border border-rose-500/10 text-rose-300 px-5 py-4 rounded-2xl">
                {{ session('error') }}
            </div>

        @endif

        {{-- INFO CARD --}}
        <div class="bg-[#12121c]/80 backdrop-blur-sm rounded-[28px] border border-white/5 p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 mb-2">
                        Kompetisi
                    </p>

                    <h3 class="text-xl font-semibold">
                        {{ $competition->title }}
                    </h3>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 mb-2">
                        Owner
                    </p>

                    <h3 class="text-xl font-semibold">
                        {{ $lobby->user->name }}
                    </h3>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 mb-2">
                        Jumlah Anggota
                    </p>

                    <h3 class="text-xl font-semibold">
                        {{ $lobby->members->count() }} / {{ $lobby->max_members }}
                    </h3>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 mb-2">
                        Status
                    </p>

                    @if($isOwner)

                        <span class="bg-indigo-500/10 text-indigo-300 px-3 py-1 rounded-full text-sm font-medium">
                            Owner
                        </span>

                    @elseif($isMember)

                        <span class="bg-emerald-500/10 text-emerald-300 px-3 py-1 rounded-full text-sm font-medium">
                            Anggota
                        </span>

                    @else

                        <span class="bg-white/5 text-slate-300 px-3 py-1 rounded-full text-sm font-medium">
                            Belum Bergabung
                        </span>

                    @endif

                </div>

            </div>

            {{-- JOIN / LEAVE --}}
            @if(!$isOwner)

                <div class="mt-8 pt-8 border-t border-white/5">

                    @if($isMember)

                        <form action="{{ route('competitions.lobbies.leave', [$competition, $lobby]) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-rose-500/90 hover:bg-rose-500 transition-all duration-300 px-6 py-3 rounded-2xl font-medium">
                                Keluar Lobby
                            </button>

                        </form>

                    @else

                        <form action="{{ route('competitions.lobbies.join', [$competition, $lobby]) }}"
                              method="POST">

                            @csrf

                            <button
                                class="bg-indigo-500 hover:bg-indigo-400 transition-all duration-300 px-6 py-3 rounded-2xl font-medium">
                                Gabung Lobby
                            </button>

                        </form>

                    @endif

                </div>

            @endif

        </div>

        {{-- SKILL SLOT --}}
        <div class="bg-[#12121c]/80 backdrop-blur-sm rounded-[28px] border border-white/5 p-8">

            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">

                <div>
                    <h2 class="text-2xl font-semibold">
                        Skill Slots
                    </h2>

                    <p class="text-slate-400 text-sm mt-1">
                        Posisi skill yang dibutuhkan oleh tim.
                    </p>
                </div>

                @if($isOwner)

                    <a href="{{ route('lobbies.skill-slots.create', $lobby) }}"
                       class="bg-indigo-500 hover:bg-indigo-400 transition-all duration-300 px-5 py-3 rounded-2xl text-sm font-medium">
                        + Tambah Slot
                    </a>

                @endif

            </div>

            @if($lobby->skillSlots->isEmpty())

                <div class="text-center py-14">

                    <p class="text-slate-500">
                        Belum ada skill slot.
                    </p>

                </div>

            @else

                <div class="space-y-4">

                    @foreach($lobby->skillSlots as $slot)

                        <div class="bg-[#181825] rounded-2xl px-5 py-4 hover:bg-[#1d1d2b] transition-all duration-300 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                            <div>

                                <h3 class="text-lg font-semibold">
                                    {{ $slot->skill_name }}
                                </h3>

                                <p class="text-sm text-slate-400 mt-1">
                                    {{ $slot->filledBy ? 'Diisi oleh ' . $slot->filledBy->name : 'Masih kosong' }}
                                </p>

                            </div>

                            <div class="flex flex-wrap gap-2">

                                @if(!$slot->filled_by && $isMember)

                                    <form action="{{ route('lobbies.skill-slots.take', [$lobby, $slot]) }}"
                                          method="POST">

                                        @csrf

                                        <button
                                            class="bg-emerald-500 hover:bg-emerald-400 transition-all duration-300 px-4 py-2 rounded-xl text-sm font-medium">
                                            Ambil
                                        </button>

                                    </form>

                                @endif

                                @if($slot->filled_by === Auth::id())

                                    <form action="{{ route('lobbies.skill-slots.release', [$lobby, $slot]) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="bg-orange-500 hover:bg-orange-400 transition-all duration-300 px-4 py-2 rounded-xl text-sm font-medium">
                                            Lepas
                                        </button>

                                    </form>

                                @endif

                                @if($isOwner)

                                    <form action="{{ route('lobbies.skill-slots.destroy', [$lobby, $slot]) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="bg-rose-500 hover:bg-rose-400 transition-all duration-300 px-4 py-2 rounded-xl text-sm font-medium">
                                            Hapus
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

        {{-- BACK --}}
        <div>

            <a href="{{ route('competitions.show', $competition) }}"
               class="text-slate-500 hover:text-white transition-all duration-300 text-sm">
                ← Kembali ke Kompetisi
            </a>

        </div>

    </div>

</div>

@endsection