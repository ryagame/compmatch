<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800 leading-tight uppercase tracking-tight">
                Detail Kompetisi
            </h2>
            <a href="{{ route('competitions.index') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-2 px-4 rounded text-xs uppercase tracking-widest transition">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Bagian Utama Detail Lomba --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                {{-- Banner/Poster Area --}}
                <div class="w-full h-72 bg-indigo-50 border-b border-slate-100 flex items-center justify-center overflow-hidden">
                    @if($competition->poster)
                        <img src="{{ Storage::url($competition->poster) }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex flex-col items-center opacity-20">
                            <span class="text-indigo-600 font-black text-6xl italic">COMPMATCH</span>
                        </div>
                    @endif
                </div>

                <div class="p-8">
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="text-[10px] font-black uppercase tracking-widest bg-indigo-600 text-white px-3 py-1 rounded">
                            {{ $competition->category }}
                        </span>
                    </div>

                    <h1 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
                        {{ $competition->title }}
                    </h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 py-6 border-y border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-slate-100 rounded">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Penyelenggara</p>
                                <p class="text-sm font-bold text-slate-700">{{ $competition->user->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-rose-50 rounded">
                                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-rose-400 uppercase tracking-widest">Batas Pendaftaran</p>
                                <p class="text-sm font-bold text-rose-600">{{ $competition->deadline }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="prose prose-slate max-w-none">
                        <h4 class="text-sm font-black uppercase tracking-widest text-slate-800 mb-3">Deskripsi Lomba</h4>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $competition->description }}
                        </p>
                    </div>

                    @if(Auth::id() === $competition->user_id)
                        <div class="mt-10 pt-6 border-t border-slate-100 flex gap-3">
                            <a href="{{ route('competitions.edit', $competition) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded text-xs uppercase tracking-widest transition">
                                Edit Kompetisi
                            </a>
                            <form action="{{ route('competitions.destroy', $competition) }}" method="POST" onsubmit="return confirm('Hapus kompetisi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 font-bold py-2.5 px-6 rounded text-xs uppercase tracking-widest transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bagian Lobby Tersedia --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 tracking-tight">Lobby Tim Tersedia</h3>
                        <p class="text-xs text-slate-500 mt-1 font-medium">Temukan tim yang sedang mencari anggota untuk kolaborasi.</p>
                    </div>
                    <a href="{{ url('/competitions/'.$competition->id.'/lobbies/create') }}"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded text-xs uppercase tracking-widest transition shadow-md">
                        + Buat Lobby Baru
                    </a>
                </div>

                @if($competition->lobbies->isEmpty())
                    <div class="py-12 border-2 border-dashed border-slate-100 rounded-lg text-center">
                        <p class="text-slate-400 text-sm font-medium">Belum ada lobby tim. Ayo mulai buat lobby pertamamu!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($competition->lobbies as $lobby)
                            <div class="group border border-slate-200 rounded-lg p-5 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="font-bold text-slate-900 group-hover:text-indigo-600 transition tracking-tight">{{ $lobby->name }}</h4>
                                    <span class="text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded">
                                        {{ $lobby->status ?? 'Tersedia' }}
                                    </span>
                                </div>
                                
                                <div class="space-y-2 mb-6">
                                    <div class="flex items-center text-xs text-slate-500 font-medium">
                                        <svg class="w-4 h-4 mr-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        {{ $lobby->members_count ?? '0' }} / {{ $lobby->max_members ?? '4' }} Anggota bergabung
                                    </div>
                                    <div class="flex items-center text-xs text-slate-500 font-medium">
                                        <svg class="w-4 h-4 mr-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                        {{ $lobby->skill_slots_count ?? '0' }} Slot skill dibutuhkan
                                    </div>
                                </div>

                                <a href="/lobbies/{{ $lobby->id }}"
                                    class="block w-full text-center bg-slate-900 hover:bg-indigo-600 text-white py-2 rounded text-[10px] font-black uppercase tracking-widest transition">
                                    Lihat Detail Tim &rarr;
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>