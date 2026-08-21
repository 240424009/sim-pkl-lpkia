<x-guest-layout>
    <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-2xl rounded-2xl border-t-8 border-red-600">
        
        <!-- LOGO & HEADER JUDUL -->
        <div class="text-center mb-6">
            <!-- Logo LPKIA -->
            <img src="{{ asset('images/Institut Digital Ekonomi LPKIA Bandung.png') }}" alt="Logo LPKIA" class="h-16 mx-auto mb-3 object-contain">

            <!-- Nama Naungan Utama (Kampus) -->
            <h2 class="text-base font-extrabold text-red-600 uppercase tracking-wide">
                INSTITUT DIGITAL EKONOMI LPKIA
            </h2>

            <!-- Pill / Badge Luhur -->
            <div class="mt-2 mb-1">
                <span class="inline-block px-3 py-0.5 bg-blue-100/80 text-blue-700 font-extrabold text-[10px] uppercase tracking-wider rounded-full">
                    PORTAL MASUK
                </span>
            </div>

            <!-- Judul Aplikasi -->
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                SIM-PKL
            </h1>

            <!-- Sub-Text Kepanjangan -->
            <p class="text-xs font-semibold text-slate-500 mt-0.5">
                Sistem Informasi & Monitoring PKL
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block font-bold text-sm text-gray-800 mb-1">Email</label>
                <input id="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 text-sm py-2 px-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email anda..." />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block font-bold text-sm text-gray-800 mb-1">Password</label>
                <input id="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-600 focus:ring focus:ring-blue-200 text-sm py-2 px-3" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-sm pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-800 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-xs font-semibold text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-red-600 hover:text-red-800 underline rounded-md" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- SUBMIT BUTTON (WARNA BIRU LPKEA KATINGALI JELAS) -->
            <div class="pt-3">
                <button type="submit" style="background-color: #0c4a6e; color: #ffffff;" class="w-full py-3 px-4 font-bold text-sm rounded-lg shadow-md hover:opacity-90 transition duration-200 uppercase tracking-wider block text-center cursor-pointer">
                    MASUK AKUN
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>