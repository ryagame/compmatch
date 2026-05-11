<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-slate-900 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
    </x-slot>

    {{-- Latar belakang keseluruhan dibuat lebih abu-abu sedikit (bg-gray-50) --}}
    <div class="py-12 bg-gray-50">
        {{-- Mengubah container agar tidak terlalu lebar, sama seperti beranda --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            {{-- Setiap Card Form diberi styling agar mirip Card Kompetisi --}}
            <div class="p-6 sm:p-10 bg-white shadow-sm rounded-xl border border-gray-100">
                <div class="max-w-3xl"> {{-- Memperlebar area form sedikit --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Bagian SKILL yang kita buat senada --}}
            <div class="p-6 sm:p-10 bg-white shadow-sm rounded-xl border border-gray-100">
                <div class="max-w-3xl">
                    @include('profile.partials.update-skills-form')
                </div>
            </div>

            {{-- Bagian Password --}}
            <div class="p-6 sm:p-10 bg-white shadow-sm rounded-xl border border-gray-100">
                <div class="max-w-3xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Bagian Hapus Akun ditaruh paling bawah --}}
            <div class="p-6 sm:p-10 bg-white shadow-sm rounded-xl border border-gray-100">
                <div class="max-w-3xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>