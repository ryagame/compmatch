@extends('layouts.app')

@section('title', 'Tambah Kompetisi')

@section('content')

<div class="min-h-screen bg-[#0b0b14] text-white">

    {{-- HERO --}}
    <section class="border-b border-white/5">

        <div class="max-w-6xl mx-auto px-6 py-14">

            <a href="{{ route('competitions.index') }}"
               class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition mb-10">
                ← Kembali ke daftar lomba
            </a>

            <div class="grid lg:grid-cols-2 gap-14 items-center">

                {{-- LEFT --}}
                <div>

                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 text-indigo-300 text-xs font-semibold tracking-wider uppercase border border-indigo-500/20 mb-6">
                        ✨ CompMatch
                    </span>

                    <h1 class="text-5xl font-black leading-tight tracking-tight mb-6">
                        Buat Kompetisi
                        <span class="text-indigo-400">
                            Lebih Menarik
                        </span>
                    </h1>

                    <p class="text-slate-400 text-lg leading-relaxed mb-10">
                        Publikasikan lomba, cari anggota tim terbaik,
                        dan bangun kolaborasi yang nyaman untuk semua peserta.
                    </p>

                    {{-- BENEFITS --}}
                    <div class="space-y-4">

                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-white/5 flex items-center justify-center text-lg">
                                🏆
                            </div>

                            <div>
                                <h3 class="font-semibold text-white">
                                    Kelola Kompetisi
                                </h3>

                                <p class="text-sm text-slate-400 mt-1">
                                    Atur lomba dengan tampilan modern dan mudah dipahami.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-white/5 flex items-center justify-center text-lg">
                                👥
                            </div>

                            <div>
                                <h3 class="font-semibold text-white">
                                    Cari Tim
                                </h3>

                                <p class="text-sm text-slate-400 mt-1">
                                    Temukan anggota dengan skill yang sesuai kebutuhan.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-2xl bg-white/5 flex items-center justify-center text-lg">
                                🚀
                            </div>

                            <div>
                                <h3 class="font-semibold text-white">
                                    Publikasi Cepat
                                </h3>

                                <p class="text-sm text-slate-400 mt-1">
                                    Buat kompetisi hanya dalam beberapa langkah sederhana.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div>

                    <div class="bg-[#12121d] border border-white/5 rounded-[32px] shadow-2xl overflow-hidden">

                        {{-- HEADER --}}
                        <div class="px-8 py-7 border-b border-white/5">

                            <h2 class="text-2xl font-bold tracking-tight">
                                Informasi Kompetisi
                            </h2>

                            <p class="text-slate-400 text-sm mt-2">
                                Isi data kompetisi dengan lengkap.
                            </p>

                        </div>

                        {{-- FORM --}}
                        <form
                            action="{{ route('competitions.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="p-8 space-y-6">

                            @csrf

                            {{-- TITLE --}}
                            <div>

                                <label class="block text-sm font-medium text-slate-300 mb-3">
                                    Nama Kompetisi
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    value="{{ old('title') }}"
                                    placeholder="Contoh: UI/UX National Challenge"
                                    class="w-full bg-[#1a1a28] border border-white/5 rounded-2xl px-5 py-4 text-white placeholder:text-slate-500 focus:outline-none focus:border-indigo-500 transition">

                                @error('title')
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
                                    placeholder="Jelaskan detail kompetisi..."
                                    class="w-full bg-[#1a1a28] border border-white/5 rounded-2xl px-5 py-4 text-white placeholder:text-slate-500 focus:outline-none focus:border-indigo-500 transition">{{ old('description') }}</textarea>

                                @error('description')
                                    <p class="text-rose-400 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- GRID --}}
                            <div class="grid md:grid-cols-2 gap-5">

                                {{-- CATEGORY --}}
                                <div>

                                    <label class="block text-sm font-medium text-slate-300 mb-3">
                                        Kategori
                                    </label>

                                    <select
                                        name="category"
                                        class="w-full bg-[#1a1a28] border border-white/5 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition">

                                        <option value="">Pilih kategori</option>
                                        <option value="Desain">Desain</option>
                                        <option value="Teknologi">Teknologi</option>
                                        <option value="Bisnis">Bisnis</option>
                                        <option value="Seni">Seni</option>

                                    </select>

                                    @error('category')
                                        <p class="text-rose-400 text-sm mt-2">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                {{-- DEADLINE --}}
                                <div>

                                    <label class="block text-sm font-medium text-slate-300 mb-3">
                                        Deadline
                                    </label>

                                    <input
                                        type="date"
                                        name="deadline"
                                        value="{{ old('deadline') }}"
                                        class="w-full bg-[#1a1a28] border border-white/5 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition">

                                    @error('deadline')
                                        <p class="text-rose-400 text-sm mt-2">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                            {{-- POSTER --}}
                            <div>

                                <label class="block text-sm font-medium text-slate-300 mb-3">
                                    Poster Kompetisi
                                </label>

                                <input
                                    type="file"
                                    name="poster"
                                    class="w-full bg-[#1a1a28] border border-white/5 rounded-2xl px-5 py-4 text-slate-400">

                                @error('poster')
                                    <p class="text-rose-400 text-sm mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- BUTTON --}}
                            <div class="flex justify-end gap-3 pt-4">

                                <a href="{{ route('competitions.index') }}"
                                   class="px-5 py-3 rounded-2xl bg-white/5 hover:bg-white/10 text-slate-300 text-sm font-medium transition">
                                    Batal
                                </a>

                                <button
                                    type="submit"
                                    class="px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition shadow-lg shadow-indigo-900/30">
                                    Simpan Kompetisi
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection