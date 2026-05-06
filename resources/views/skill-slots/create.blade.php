<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Skill Slot — {{ $lobby->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form action="{{ route('lobbies.skill-slots.store', $lobby) }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Skill</label>
                        <input type="text" name="skill_name" value="{{ old('skill_name') }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                               placeholder="Contoh: Frontend Developer, UI Designer, Backend Developer">
                        @error('skill_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Tambah Slot
                        </button>
                        <a href="{{ route('competitions.lobbies.show', [$lobby->competition_id, $lobby]) }}"
                           class="text-gray-500 hover:underline text-sm">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>