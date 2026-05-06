<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏠 {{ $lobby->name }}
            </h2>
            @if($isOwner)
    <div class="flex gap-2">
        {{-- Tombol Matchmaking --}}
        <form action="{{ route('competitions.lobbies.matchmaking', [$competition, $lobby]) }}"
              method="POST"
              onsubmit="return confirm('Jalankan matchmaking otomatis?')">
            @csrf
            <button class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 text-sm font-medium">
                🎲 Matchmaking
            </button>
        </form>

        <form action="{{ route('competitions.lobbies.resetMatchmaking', [$competition, $lobby]) }}"
      method="POST"
      onsubmit="return confirm('Reset semua slot?')">
    @csrf
    <button class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 text-sm font-medium">
        🔄 Reset Slot
    </button>
</form>

        <a href="{{ route('competitions.lobbies.edit', [$competition, $lobby]) }}"
           class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 text-sm font-medium">
            ✏️ Edit
        </a>
        <form action="{{ route('competitions.lobbies.destroy', [$competition, $lobby]) }}"
              method="POST" onsubmit="return confirm('Hapus lobby ini?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm font-medium">
                🗑️ Hapus
            </button>
        </form>
    </div>
@endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded-lg">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-100 text-red-700 rounded-lg">❌ {{ session('error') }}</div>
            @endif

            {{-- Info Lobby --}}
            <div class="bg-white rounded-xl shadow p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Kompetisi</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $competition->title }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Dibuat oleh</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $lobby->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Anggota</p>
                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $lobby->members->count() }} / {{ $lobby->max_members }}
                            @if($lobby->members->count() >= $lobby->max_members)
                                <span class="text-xs text-red-500 ml-1">(Penuh)</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Status</p>
                        <p class="mt-1">
                            @if($isOwner)
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Owner</span>
                            @elseif($isMember)
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Anggota</span>
                            @else
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">Bukan Anggota</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Tombol Join / Leave --}}
                @if(!$isOwner)
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        @if($isMember)
                            <form action="{{ route('competitions.lobbies.leave', [$competition, $lobby]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600 text-sm font-medium">
                                    🚪 Keluar dari Lobby
                                </button>
                            </form>
                        @else
                            <form action="{{ route('competitions.lobbies.join', [$competition, $lobby]) }}"
                                  method="POST">
                                @csrf
                                <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 text-sm font-medium">
                                    ✅ Gabung Lobby
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Daftar Anggota --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">👥 Anggota Lobby</h3>
                @if($lobby->members->isEmpty())
                    <p class="text-gray-400 text-sm">Belum ada anggota.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($lobby->members as $member)
                            <li class="flex items-center gap-3 bg-gray-50 px-4 py-3 rounded-lg">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-sm">
                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                </div>
                                <span class="text-gray-700 font-medium">{{ $member->user->name }}</span>
                                @if($member->user_id === $lobby->user_id)
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Owner</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Skill Slots --}}
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">🎯 Skill Slots</h3>
                    @if($isOwner)
                        <a href="{{ route('lobbies.skill-slots.create', $lobby) }}"
                           class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 text-sm font-medium">
                            + Tambah Slot
                        </a>
                    @endif
                </div>

                @if($lobby->skillSlots->isEmpty())
                    <p class="text-gray-400 text-sm">Belum ada skill slot.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($lobby->skillSlots as $slot)
                            <li class="flex items-center justify-between bg-gray-50 px-4 py-3 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $slot->skill_name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $slot->filledBy ? '✅ ' . $slot->filledBy->name : '⬜ Kosong' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    {{-- Tombol Take --}}
                                    @if($slot->filled_by === null && $isMember && !$isOwner)
                                        <form action="{{ route('lobbies.skill-slots.take', [$lobby, $slot]) }}" method="POST">
                                            @csrf
                                            <button class="text-xs bg-green-500 text-white px-3 py-1.5 rounded-lg hover:bg-green-600">
                                                Ambil
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Release --}}
                                    @if($slot->filled_by === Auth::id())
                                        <form action="{{ route('lobbies.skill-slots.release', [$lobby, $slot]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-xs bg-orange-500 text-white px-3 py-1.5 rounded-lg hover:bg-orange-600">
                                                Lepas
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Hapus slot (owner only) --}}
                                    @if($isOwner)
                                        <form action="{{ route('lobbies.skill-slots.destroy', [$lobby, $slot]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-xs bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <a href="{{ route('competitions.show', $competition) }}"
               class="inline-block text-gray-500 hover:underline text-sm">
                ← Kembali ke Kompetisi
            </a>

        </div>
    </div>
</x-app-layout>