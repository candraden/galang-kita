<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-semibold tracking-tight text-ink">Masuk ke akunmu</h2>
        <p class="mt-1 text-sm text-ink-muted">Pantau iuran dan kewajibanmu di satu tempat.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div class="space-y-1.5">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                          placeholder="nama@email.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Kata Sandi" />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="rounded text-xs font-semibold text-primary-dark hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password"
                          placeholder="Masukkan kata sandi" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <label for="remember_me" class="inline-flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="h-4 w-4 rounded border-line text-primary focus:ring-primary">
            <span class="text-sm text-ink-muted">Ingat saya</span>
        </label>

        <x-primary-button class="w-full">Masuk</x-primary-button>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-ink-muted">
            Belum punya akun?
            <a href="{{ route('register') }}"
               class="rounded font-semibold text-primary-dark hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                Daftar
            </a>
        </p>
    @endif
</x-guest-layout>