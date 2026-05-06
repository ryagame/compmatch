<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Lobby — {{ $competition->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form action="{{ route('competitions.lobbies.store', $competition) }}" method="POST">
                    @csrf

                    {{-- Nama Lobby --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lobby</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                               placeholder="Contoh: Tim Garuda A">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Max Members --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Maksimal Anggota</label>
                        <input type="number" name="max_members" value="{{ old('max_members', 4) }}"
                               min="2" max="20"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                        @error('max_members')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Buat Lobby
                        </button>
                        <a href="{{ route('competitions.show', $competition) }}"
                           class="text-gray-500 hover:underline text-sm">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>