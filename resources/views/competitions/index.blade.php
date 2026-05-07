<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">🏆 Daftar Lomba</h2>
            <a href="{{ route('competitions.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm">
                + Tambah Lomba
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-10 text-white shadow-2xl">

        <div class="absolute right-0 top-0 opacity-10 text-[180px] font-black leading-none">
            🏆
        </div>

        <div class="relative z-10">
            <span class="bg-white/20 px-4 py-1 rounded-full text-sm">
                CompMatch Platform
            </span>

            <h1 class="text-4xl font-extrabold mt-4 mb-3 leading-tight">
                Temukan Lomba dan Bangun Tim Terbaikmu
            </h1>

            <p class="text-blue-100 max-w-2xl text-lg leading-relaxed">
                Cari kompetisi, buat lobby tim, isi role seperti UI/UX,
                Frontend, Backend, dan Data Analyst untuk memenangkan lomba bersama.
            </p>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('competitions.create') }}"
                    class="bg-white text-blue-700 font-semibold px-5 py-3 rounded-2xl hover:scale-105 transition">
                    + Tambah Lomba
                </a>

                <a href="#competition-list"
                    class="bg-white/20 backdrop-blur text-white px-5 py-3 rounded-2xl hover:bg-white/30 transition">
                    Jelajahi Lomba
                </a>
            </div>
        </div>
    </div>
</div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($competitions->isEmpty())
                <div class="text-center py-20 text-gray-400">
                    <p class="text-6xl mb-4">📭</p>
                    <p class="text-xl font-semibold">Belum ada lomba</p>
                    <p class="text-sm mt-1">Jadilah yang pertama menambahkan lomba!</p>
                </div>
            @else

            {{-- Search & Filter --}}
<div class="mb-8 bg-white rounded-3xl shadow-lg border border-gray-100 p-5 flex flex-col sm:flex-row gap-3">
    <form method="GET" action="{{ route('competitions.index') }}" class="flex flex-1 gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="🔍 Cari kompetisi..."
               class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">

        <select name="category"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
            Cari
        </button>

        @if(request('search') || request('category'))
            <a href="{{ route('competitions.index') }}"
               class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-200 text-sm font-medium">
                ✕ Reset
            </a>
        @endif
    </form>
</div>
            
                <div id="competition-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($competitions as $competition)
                        <div class="group bg-white rounded-3xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:-translate-y-2 flex flex-col">
                            @if($competition->poster)
                                <img src="{{ Storage::url($competition->poster) }}"
                                    class="w-full h-52 object-cover group-hover:scale-105 transition duration-500"
                            @else
                                <div class="w-full h-44 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <span class="text-5xl">🏆</span>
                                </div>
                            @endif

                            <div class="p-5 flex flex-col flex-1">
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full w-fit">
                                    {{ $competition->category }}
                                </span>
                                <h3 class="font-bold text-lg mt-2 text-gray-800">{{ $competition->title }}</h3>
                                <p class="text-gray-500 text-sm mt-1 line-clamp-2 flex-1">{{ $competition->description }}</p>
                                <div class="mt-3 flex items-center justify-between">
    <span class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full">
        ⏰ {{ $competition->deadline }}
    </span>

    <span class="text-xs text-gray-400">
        👤 {{ $competition->user->name }}
    </span>
</div>

                                <div class="flex gap-2 mt-4">
                                    <a href="{{ route('competitions.show', $competition) }}"
                                        class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium">
                                        Lihat Detail
                                    </a>
                                    @if(Auth::id() === $competition->user_id)
                                        <a href="{{ route('competitions.edit', $competition) }}"
                                            class="text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-3 rounded-lg text-sm">
                                            ✏️
                                        </a>
                                        <form action="{{ route('competitions.destroy', $competition) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-100 hover:bg-red-200 text-red-700 py-2 px-3 rounded-lg text-sm">
                                                🗑️
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