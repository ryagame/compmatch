<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 relative overflow-hidden">

    <!-- EFFECT -->
    <div class="absolute top-0 left-0 w-full h-full opacity-20">
        <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl top-10 left-10"></div>
        <div class="absolute w-[500px] h-[500px] bg-pink-300 rounded-full blur-3xl bottom-0 right-0"></div>
    </div>

    <!-- LOGIN CARD -->
    <div class="relative z-10 w-full max-w-6xl mx-6 bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl rounded-[40px] overflow-hidden">

        <div class="grid lg:grid-cols-2 min-h-[700px]">

            <!-- LEFT CONTENT -->
            <div class="flex flex-col justify-center items-center text-center p-16 text-white">

                <img src="{{ asset('images/compmatchlogin.png') }}"
                     alt="CompMatch"
                     class="w-[420px] drop-shadow-2xl">

                <h1 class="text-6xl font-black mt-8">
                    CompMatch
                </h1>

                <p class="text-2xl text-blue-100 mt-4">
                    Connect, Collaborate, Compete
                </p>

                <div class="mt-10 text-lg leading-relaxed max-w-xl text-blue-50">
                    Temukan teammate terbaik, bangun lobby lomba,
                    dan lakukan matchmaking dengan mahasiswa lain
                    untuk memenangkan kompetisi bersama.
                </div>

            </div>

            <!-- RIGHT CONTENT -->
            <div class="bg-white flex items-center justify-center p-16">

                <div class="w-full max-w-md">

                    <h2 class="text-5xl font-black text-gray-800 mb-3">
                        Welcome Back
                    </h2>

                    <p class="text-gray-500 text-lg mb-10">
                        Login ke akun CompMatch kamu
                    </p>

                    <!-- STATUS -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- EMAIL -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-5 py-4 text-lg shadow-sm">
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Password
                            </label>

                            <input type="password"
                                   name="password"
                                   required
                                   class="w-full rounded-2xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 px-5 py-4 text-lg shadow-sm">
                        </div>

                        <!-- REMEMBER -->
                        <div class="flex items-center justify-between">

                            <label class="flex items-center text-gray-600">
                                <input type="checkbox"
                                       name="remember"
                                       class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">

                                <span class="ml-2">
                                    Remember me
                                </span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-blue-600 hover:text-purple-600 font-semibold">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                            class="w-full py-4 rounded-2xl text-white font-bold text-lg bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 shadow-xl transition duration-300">
                            LOG IN
                        </button>

                        <!-- REGISTER -->
                        @if (Route::has('register'))
                            <p class="text-center text-gray-500 mt-8">
                                Belum punya akun?
                                <a href="{{ route('register') }}"
                                   class="font-bold text-purple-600 hover:underline">
                                    Daftar sekarang
                                </a>
                            </p>
                        @endif

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</x-guest-layout>