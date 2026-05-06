<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Lomba</h2>
            <a href="{{ route('competitions.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg text-sm">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-lg">✅ {{ session('success') }}</div>
            @endif

            {{-- Info Lomba --}}
            <div class="bg-white rounded-xl shadow p-8">
                @if($competition->poster)
                    <img src="{{ Storage::url($competition->poster) }}"
                        class="w-full h-60 object-cover rounded-xl mb-6">
                @else
                    <div class="w-full h-40 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl mb-6 flex items-center justify-center">
                        <span class="text-6xl">🏆</span>
                    </div>
                @endif

                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                    {{ $competition->category }}
                </span>
                <h1 class="text-2xl font-bold mt-3 text-gray-800">{{ $competition->title }}</h1>
                <p class="text-gray-500 text-sm mt-1">👤 Oleh: {{ $competition->user->name }}</p>
                <p class="text-red-500 text-sm mt-1">⏰ Deadline: {{ $competition->deadline }}</p>
                <p class="text-gray-700 mt-4 leading-relaxed">{{ $competition->description }}</p>

                @if(Auth::id() === $competition->user_id)
                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('competitions.edit', $competition) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm">
                            ✏️ Edit Lomba
                        </a>
                        <form action="{{ route('competitions.destroy', $competition) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus lomba ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg text-sm">
                                🗑️ Hapus Lomba
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Daftar Lobby --}}
            <div class="bg-white rounded-xl shadow p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-800">🏠 Lobby Tersedia</h2>
                    <a href="{{ route('competitions.lobbies.create', $competition) }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-sm">
                        + Buat Lobby
                    </a>
                </div>

                @if($competition->lobbies->isEmpty())
                    <div class="text-center py-10 text-gray-400">
                        <p class="text-4xl mb-2">🏠</p>
                        <p>Belum ada lobby untuk lomba ini</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($competition->lobbies as $lobby)
                            <div class="border border-gray-200 rounded-xl p-5 hover:shadow-sm transition">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-gray-800">{{ $lobby->name }}</h3>
                                    @if($lobby->members->count() >= $lobby->max_members)
                                        <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">Penuh</span>
                                    @else
                                        <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">Tersedia</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 mt-2">
                                    👥 {{ $lobby->members->count() }} / {{ $lobby->max_members }} anggota
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    🎯 {{ $lobby->skillSlots->count() }} skill slot
                                </p>
                                <a href="{{ route('competitions.lobbies.show', [$competition, $lobby]) }}"
                                    class="mt-4 block text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg text-sm font-medium">
                                    Lihat Lobby →
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>