<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-semibold tracking-tight text-ink">Buat akun baru</h2>
        <p class="mt-1 text-sm text-ink-muted">Gabung ke grup atau mulai kelola dana kelompokmu.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" type="text" name="name" :value="old('name')"
                          placeholder="Nama sesuai identitas" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div class="space-y-1.5">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                          placeholder="nama@email.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Role -->
        <fieldset class="space-y-1.5">
            <legend class="block text-xs font-medium text-ink-muted">Daftar sebagai</legend>
            <div class="grid gap-3 sm:grid-cols-2">
                <label class="cursor-pointer">
                    <input type="radio" name="role" value="member" class="peer sr-only" required
                           @checked(old('role', 'member') === 'member')>
                    <div class="h-full rounded-input border-[1.5px] border-line p-3.5 transition peer-checked:border-primary peer-checked:bg-primary-tint/40 peer-focus-visible:ring-2 peer-focus-visible:ring-primary/40">
                        <p class="text-sm font-semibold text-ink">Anggota</p>
                        <p class="mt-0.5 text-xs text-ink-muted">Membayar iuran dan kirim bukti</p>
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="role" value="fundraiser" class="peer sr-only"
                           @checked(old('role') === 'fundraiser')>
                    <div class="h-full rounded-input border-[1.5px] border-line p-3.5 transition peer-checked:border-primary peer-checked:bg-primary-tint/40 peer-focus-visible:ring-2 peer-focus-visible:ring-primary/40">
                        <p class="text-sm font-semibold text-ink">Penggalang Dana</p>
                        <p class="mt-0.5 text-xs text-ink-muted">Mengelola grup dan verifikasi</p>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" />
        </fieldset>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-input-label for="password" value="Kata Sandi" />
            <x-text-input id="password" type="password" name="password"
                          placeholder="Minimal 8 karakter" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                          placeholder="Ulangi kata sandi" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button class="w-full">Daftar</x-primary-button>
    </form>

    <p class="mt-6 text-center text-sm text-ink-muted">
        Sudah punya akun?
        <a href="{{ route('login') }}"
           class="rounded font-semibold text-primary-dark hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-primary">
            Masuk
        </a>
    </p>
</x-guest-layout>