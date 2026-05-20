@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#070711] py-10 px-6">

    <div class="max-w-2xl mx-auto">

        <div class="bg-[#11111d] border border-white/10 rounded-3xl shadow-2xl overflow-hidden">

            {{-- HEADER --}}
            <div class="px-8 py-6 border-b border-white/10">
                <h1 class="text-3xl font-black text-white tracking-tight">
                    Edit Lobby
                </h1>

                <p class="text-slate-400 mt-2 text-sm">
                    Perbarui informasi lobby tim kamu.
                </p>
            </div>

            {{-- FORM --}}
            <form action="{{ route('competitions.lobbies.update', [$competition, $lobby]) }}"
                  method="POST"
                  class="p-8 space-y-8">

                @csrf
                @method('PATCH')

                {{-- NAMA LOBBY --}}
                <div>
                    <label class="block text-sm font-bold text-white mb-3">
                        Nama Lobby
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $lobby->name) }}"
                        placeholder="Masukkan nama lobby"
                        class="w-full bg-[#1b1b2d] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    @error('name')
                        <p class="text-rose-400 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- MAX MEMBERS --}}
                <div>
                    <label class="block text-sm font-bold text-white mb-3">
                        Maksimal Anggota
                    </label>

                    <input
                        type="number"
                        name="max_members"
                        value="{{ old('max_members', $lobby->max_members) }}"
                        min="2"
                        max="20"
                        class="w-full bg-[#1b1b2d] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    @error('max_members')
                        <p class="text-rose-400 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- BUTTON --}}
                <div class="flex items-center justify-end gap-4 pt-4">

                    <a href="{{ route('competitions.lobbies.show', [$competition, $lobby]) }}"
                       class="px-6 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold transition">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-8 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black tracking-wide transition shadow-lg shadow-indigo-900/40">

                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection