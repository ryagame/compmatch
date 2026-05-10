<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 relative overflow-hidden">

    <div class="absolute inset-0 opacity-20">
        <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl top-10 left-10"></div>
        <div class="absolute w-[500px] h-[500px] bg-pink-300 rounded-full blur-3xl bottom-0 right-0"></div>
    </div>

    <div class="relative z-10 w-full max-w-2xl mx-6 bg-white rounded-[36px] shadow-2xl p-12">

        <div class="text-center mb-8">
            <img src="{{ asset('images/compmatchlogin.png') }}"
                 alt="CompMatch"
                 class="w-60 mx-auto mb-4">

            <h1 class="text-4xl font-black text-gray-800">
                Buat Akun CompMatch
            </h1>

            <p class="text-gray-500 mt-2">
                Daftar untuk mulai mencari tim lomba terbaikmu
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-5 py-4">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-5 py-4">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-2xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 px-5 py-4">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-2xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 px-5 py-4">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full py-4 rounded-2xl text-white font-bold text-lg bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 shadow-xl transition">
                REGISTER
            </button>

            <p class="text-center text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-purple-600 hover:underline">
                    Login sekarang
                </a>
            </p>
        </form>
    </div>
</div>

</x-guest-layout>