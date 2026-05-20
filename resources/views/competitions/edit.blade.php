@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-[#070711] py-10 px-6">

        <div class="max-w-4xl mx-auto">

            <div class="bg-[#11111d] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">

                {{-- HEADER --}}
                <div class="px-8 py-6 border-b border-white/10">
                    <h1 class="text-3xl font-black text-white tracking-tight">
                        Edit Data Kompetisi
                    </h1>

                    <p class="text-slate-400 mt-2 text-sm">
                        Perbarui informasi lomba kamu di bawah ini.
                    </p>
                </div>

                {{-- FORM --}}
                <form
                    action="{{ route('competitions.update', $competition->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-8 space-y-8">

                    @csrf
                    @method('PUT')

                    {{-- TITLE --}}
                    <div>
                        <label class="block text-sm font-bold text-white mb-3">
                            Nama Kompetisi
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $competition->title) }}"
                            class="w-full bg-[#1b1b2d] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Masukkan nama kompetisi">

                        @error('title')
                            <p class="text-rose-400 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- DESCRIPTION --}}
                    <div>
                        <label class="block text-sm font-bold text-white mb-3">
                            Deskripsi Kompetisi
                        </label>

                        <textarea
                            name="description"
                            rows="6"
                            class="w-full bg-[#1b1b2d] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Jelaskan detail kompetisi">{{ old('description', $competition->description) }}</textarea>

                        @error('description')
                            <p class="text-rose-400 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- CATEGORY + DEADLINE --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- CATEGORY --}}
                        <div>
                            <label class="block text-sm font-bold text-white mb-3">
                                Kategori
                            </label>

                            <select
                                name="category"
                                class="w-full bg-[#1b1b2d] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                <option value="Desain"
                                    {{ old('category', $competition->category) == 'Desain' ? 'selected' : '' }}>
                                    Desain
                                </option>

                                <option value="Teknologi"
                                    {{ old('category', $competition->category) == 'Teknologi' ? 'selected' : '' }}>
                                    Teknologi
                                </option>

                                <option value="Bisnis"
                                    {{ old('category', $competition->category) == 'Bisnis' ? 'selected' : '' }}>
                                    Bisnis
                                </option>

                                <option value="Seni"
                                    {{ old('category', $competition->category) == 'Seni' ? 'selected' : '' }}>
                                    Seni
                                </option>
                            </select>

                            @error('category')
                                <p class="text-rose-400 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- DEADLINE --}}
                        <div>
                            <label class="block text-sm font-bold text-white mb-3">
                                Deadline
                            </label>

                            <input
                                type="date"
                                name="deadline"
                                value="{{ old('deadline', $competition->deadline) }}"
                                class="w-full bg-[#1b1b2d] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            @error('deadline')
                                <p class="text-rose-400 text-sm mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- POSTER --}}
                    <div>
                        <label class="block text-sm font-bold text-white mb-3">
                            Poster Kompetisi
                        </label>

                        @if($competition->poster)
                            <img
                                src="{{ asset('storage/' . $competition->poster) }}"
                                class="w-full h-64 object-cover rounded-2xl mb-5">
                        @endif

                        <input
                            type="file"
                            name="poster"
                            class="w-full bg-[#1b1b2d] border border-white/10 rounded-2xl px-5 py-4 text-slate-300">

                        @error('poster')
                            <p class="text-rose-400 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex justify-end gap-4 pt-6">

                        <a href="{{ route('competitions.show', $competition->id) }}"
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