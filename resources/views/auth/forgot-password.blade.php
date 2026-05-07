<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 relative overflow-hidden">

    <div class="absolute inset-0 opacity-20">
        <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl top-10 left-10"></div>
        <div class="absolute w-[500px] h-[500px] bg-pink-300 rounded-full blur-3xl bottom-0 right-0"></div>
    </div>

    <div class="relative z-10 w-full max-w-xl mx-6 bg-white rounded-[36px] shadow-2xl p-12">

        <div class="text-center mb-8">
            <img src="{{ asset('images/compmatchlogin.png') }}"
                 alt="CompMatch"
                 class="w-56 mx-auto mb-4">

            <h1 class="text-4xl font-black text-gray-800">
                Lupa Password?
            </h1>

            <p class="text-gray-500 mt-3 leading-relaxed">
                Masukkan email akun kamu. Kami akan mengirimkan link untuk reset password.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-5 py-4">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full py-4 rounded-2xl text-white font-bold text-lg bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 shadow-xl transition">
                KIRIM LINK RESET
            </button>

            <p class="text-center text-gray-500">
                Ingat password?
                <a href="{{ route('login') }}" class="font-bold text-purple-600 hover:underline">
                    Kembali login
                </a>
            </p>
        </form>
    </div>
</div>

</x-guest-layout>