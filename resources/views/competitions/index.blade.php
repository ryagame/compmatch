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
<div class="mb-6 flex flex-col sm:flex-row gap-3">
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
            
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($competitions as $competition)
                        <div class="bg-white rounded-xl shadow hover:shadow-md transition p-0 flex flex-col overflow-hidden">
                            @if($competition->poster)
                                <img src="{{ Storage::url($competition->poster) }}"
                                    class="w-full h-44 object-cover">
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
                                <p class="text-sm text-red-500 mt-2">⏰ {{ $competition->deadline }}</p>
                                <p class="text-xs text-gray-400 mt-1">👤 {{ $competition->user->name }}</p>

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