@extends('layouts.app')

@section('title', 'Tambah Skill Slot')

@section('content')

<div class="min-h-screen bg-[#070711] text-white py-16 px-6">

    <div class="max-w-xl mx-auto">

        {{-- BACK --}}
        <a href="{{ route('competitions.lobbies.show', [$lobby->competition_id, $lobby->id]) }}"
           class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition mb-8">
            ← Kembali ke Lobby
        </a>

        {{-- CARD --}}
        <div class="bg-[#10101a] border border-white/5 rounded-[26px] overflow-hidden shadow-xl">

            {{-- HEADER --}}
            <div class="px-8 pt-8 pb-6 border-b border-white/5">

                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-2xl">
                        🎯
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">
                            Tambah Skill
                        </h1>

                        <p class="text-slate-400 text-sm mt-1">
                            Tambahkan posisi yang sedang dibutuhkan tim.
                        </p>
                    </div>

                </div>

            </div>

            {{-- FORM --}}
            <form action="{{ route('lobbies.skill-slots.store', $lobby) }}"
                  method="POST"
                  class="p-8 space-y-6">

                @csrf

                {{-- SKILL --}}
                <div>

                    <label class="block text-sm font-medium text-slate-300 mb-3">
                        Nama Skill
                    </label>

                    <input
                        type="text"
                        name="skill_name"
                        value="{{ old('skill_name') }}"
                        placeholder="Contoh: UI/UX Designer"
                        class="w-full bg-[#181825] border border-white/5 rounded-2xl px-5 py-4 text-white placeholder:text-slate-500 focus:outline-none focus:border-indigo-500 transition">

                    @error('skill_name')
                        <p class="text-rose-400 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- DESCRIPTION --}}
                <div>

                    <label class="block text-sm font-medium text-slate-300 mb-3">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        placeholder="Jelaskan kebutuhan skill atau tugasnya..."
                        class="w-full bg-[#181825] border border-white/5 rounded-2xl px-5 py-4 text-white placeholder:text-slate-500 focus:outline-none focus:border-indigo-500 transition">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="text-rose-400 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- BUTTON --}}
                <div class="flex items-center justify-end gap-3 pt-4">

                    <a href="{{ route('competitions.lobbies.show', [$lobby->competition_id, $lobby->id]) }}"
                       class="px-5 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-slate-300 text-sm font-medium transition">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition">
                        Tambah Skill
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection