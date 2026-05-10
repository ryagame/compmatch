<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎯 Tambah Skill Slot: {{ $lobby->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('lobbies.skill-slots.store', $lobby) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="skill_name" class="block text-sm font-medium text-gray-700">Nama Peran / Skill</label>
                        <input type="text" name="skill_name" id="skill_name" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                               placeholder="Contoh: UI/UX Designer, Backend, atau Laravel Expert" required>
                        <p class="mt-2 text-xs text-gray-500">Tentukan peran spesifik yang kamu butuhkan untuk tim ini.</p>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('competitions.lobbies.show', [$lobby->competition_id, $lobby]) }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                        <x-primary-button>
                            Simpan Slot
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>