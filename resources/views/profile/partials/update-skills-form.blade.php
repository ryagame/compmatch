<section>
    <header>
        <h2 class="text-2xl font-bold text-slate-900">
            {{ __('Expertise & Specialization') }}
        </h2>
        <p class="mt-2 text-base text-gray-600 max-w-xl">
            {{ __('Mark your technical skills. This will help our system recommend you to the most suitable teams or competitions.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.skills.update') }}" class="mt-8 space-y-8">
        @csrf
        @method('patch')

        {{-- Menggunakan flex-wrap untuk "Skill Chips" agar modern --}}
        <div class="flex flex-wrap gap-3">
            @foreach($skills as $skill)
                <label class="relative cursor-pointer group">
                    {{-- Checkbox disembunyikan tapi tetap berfungsi (sr-only) --}}
                    <input type="checkbox" 
                           name="skills[]" 
                           value="{{ $skill->id }}" 
                           class="peer sr-only"
                           {{ auth()->user()->skills->contains($skill->id) ? 'checked' : '' }}>
                    
                    {{-- Gaya "Chip" atau Label seperti label 'DESAIN' di beranda --}}
                    {{-- Gray jika tidak dipilih, Ungu jika dipilih --}}
                    <div class="px-5 py-2.5 bg-gray-100 border-2 border-transparent rounded-lg 
                                text-slate-700 font-semibold text-sm transition-all duration-200
                                hover:bg-gray-200 hover:scale-105
                                peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-700
                                peer-checked:shadow-lg">
                        {{ $skill->name }}
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex items-center gap-4 pt-4">
            {{-- Menggunakan Warna Tombol Navy (bg-slate-900) agar senada --}}
            <x-primary-button class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-8 rounded-lg shadow">
                {{ __('Save Specializations') }}
            </x-primary-button>

            @if (session('status') === 'skills-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>