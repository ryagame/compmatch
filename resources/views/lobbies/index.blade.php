<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lobby — {{ $competition->title }}
            </h2>
            <a href="{{ route('competitions.lobbies.create', $competition) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Buat Lobby
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($lobbies->isEmpty())
                <div class="text-center py-16 text-gray-500">
                    <p class="text-lg">Belum ada lobby untuk kompetisi ini.</p>
                    <a href="{{ route('competitions.lobbies.create', $competition) }}"
                       class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Buat Lobby Pertama
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($lobbies as $lobby)
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $lobby->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Dibuat oleh: {{ $lobby->user->name }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Anggota: {{ $lobby->members_count }} / {{ $lobby->max_members }}
                            </p>

                            <div class="mt-4">
                                <a href="{{ route('competitions.lobbies.show', [$competition, $lobby]) }}"
                                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('competitions.show', $competition) }}"
                   class="text-gray-500 hover:underline text-sm">
                    ← Kembali ke Detail Kompetisi
                </a>
            </div>

        </div>
    </div>
</x-app-layout>