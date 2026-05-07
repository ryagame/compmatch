<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">Daftar Lomba</h2>
            <a href="{{ route('competitions.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md text-sm transition shadow-sm">
                + Tambah Lomba
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        {{-- Hero Banner (Solid & Clean) --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
            <div class="relative overflow-hidden rounded-xl bg-indigo-700 p-12 text-white shadow-lg border border-indigo-800">
                <div class="relative z-10">
                    <span class="inline-block bg-white/20 px-3 py-1 rounded text-[10px] font-bold uppercase tracking-widest mb-4">
                        CompMatch Platform
                    </span>

                    <h1 class="text-5xl font-extrabold mb-4 leading-tight tracking-tight">
                        Temukan Lomba dan <br>Bangun Tim Terbaikmu
                    </h1>

                    <p class="text-indigo-100 max-w-2xl text-base leading-relaxed opacity-90">
                        Cari kompetisi, buat lobby tim, isi role spesifik, dan temukan rekan setim yang tepat untuk memenangkan kompetisi bersama.
                    </p>

                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('competitions.create') }}"
                            class="bg-white text-indigo-700 font-bold px-6 py-3 rounded-md hover:bg-slate-50 transition shadow-md">
                            Mulai Posting Lomba
                        </a>

                        <a href="#competition-list"
                            class="bg-indigo-800 text-white font-bold px-6 py-3 rounded-md hover:bg-indigo-900 transition border border-indigo-600">
                            Jelajahi Lomba
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($competitions->isEmpty())
                <div class="text-center py-24 border-2 border-dashed border-slate-200 rounded-2xl">
                    <p class="text-slate-400 font-medium">Belum ada lomba tersedia. Jadilah yang pertama!</p>
                </div>
            @else

                {{-- Search & Filter (Clean UI) --}}
                <div class="mb-10 bg-white rounded-lg shadow-sm border border-slate-200 p-2 flex flex-col sm:flex-row gap-2">
                    <form method="GET" action="{{ route('competitions.index') }}" class="flex flex-1 gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari kompetisi berdasarkan nama..."
                               class="flex-1 border-none bg-slate-50 rounded-md px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 text-slate-700 font-medium">

                        <select name="category"
                                class="border-none bg-slate-50 rounded-md px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 text-slate-700 font-bold">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                                class="bg-slate-900 text-white px-8 py-3 rounded-md hover:bg-slate-800 text-sm font-bold transition">
                            CARI
                        </button>

                        @if(request('search') || request('category'))
                            <a href="{{ route('competitions.index') }}"
                               class="bg-slate-100 text-slate-600 px-4 py-3 rounded-md hover:bg-slate-200 text-sm font-bold flex items-center justify-center">
                                RESET
                            </a>
                        @endif
                    </form>
                </div>
                
                {{-- Grid Lomba --}}
                <div id="competition-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($competitions as $competition)
                        <div class="group bg-white rounded-lg border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all duration-300 overflow-hidden flex flex-col">
                            
                            {{-- Poster Area --}}
                            <div class="w-full h-48 bg-slate-100 overflow-hidden border-b border-slate-100">
                                @if($competition->poster)
                                    <img src="{{ Storage::url($competition->poster) }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-indigo-50">
                                        <span class="text-indigo-200 font-black text-4xl italic uppercase">COMP</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6 flex flex-col flex-1">
                                <span class="text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-600 px-2 py-1 rounded w-fit mb-3">
                                    {{ $competition->category }}
                                </span>
                                
                                <h3 class="font-bold text-lg text-slate-900 group-hover:text-indigo-600 transition leading-tight mb-2">
                                    {{ $competition->title }}
                                </h3>
                                
                                <p class="text-slate-500 text-sm line-clamp-2 mb-4 leading-relaxed flex-1">
                                    {{ $competition->description }}
                                </p>

                                <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                    <div class="text-[11px] font-bold text-rose-600 uppercase">
                                        DL: {{ $competition->deadline }}
                                    </div>
                                    <div class="text-[11px] font-bold text-slate-400 uppercase">
                                        BY: {{ $competition->user->name }}
                                    </div>
                                </div>

                                <div class="flex gap-2 mt-6">
                                    <a href="{{ route('competitions.show', $competition) }}"
                                        class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded text-xs font-bold transition uppercase tracking-wider">
                                        Lihat Detail
                                    </a>
                                    
                                    @if(Auth::id() === $competition->user_id)
                                        <a href="{{ route('competitions.edit', $competition) }}"
                                            class="bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-600 p-2.5 rounded transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </a>
                                        
                                        <form action="{{ route('competitions.destroy', $competition) }}" method="POST"
                                            onsubmit="return confirm('Hapus lomba?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-slate-100 hover:bg-rose-600 hover:text-white text-rose-600 p-2.5 rounded transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>