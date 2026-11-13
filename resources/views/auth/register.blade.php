<x-guest-layout>
    @if ($invitationError)
        <div class="mb-6 text-center">
            <span class="mx-auto grid size-14 place-items-center rounded-full bg-danger-tint text-danger">
                <span class="material-symbols-outlined">link_off</span>
            </span>
            <h2 class="mt-4 text-2xl font-semibold tracking-tight text-ink">Tautan tidak dapat dipakai</h2>
            <p class="mt-1 text-sm text-ink-muted">{{ $invitationError }}</p>
            <p class="mt-3 text-sm text-ink-muted">Minta tautan baru kepada penggalang dana yang mengundang kamu.</p>
        </div>
        <a href="{{ route('register') }}" class="block text-center text-sm font-semibold text-primary-dark hover:underline">
            Atau daftar sebagai penggalang dana
        </a>
    @else
        @if ($invitation)
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold tracking-tight text-ink">Gabung ke {{ $invitation->group->name }}</h2>
                <p class="mt-1 text-sm text-ink-muted">Buat akun anggota untuk bergabung ke grup ini.</p>
            </div>
            <div class="mb-5 flex items-center gap-3 rounded-input bg-primary-tint/50 p-3.5">
                <x-group-avatar :group="$invitation->group" size="size-11" />
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-ink">{{ $invitation->group->name }}</p>
                    <p class="truncate text-xs text-ink-muted">Diundang oleh {{ $invitation->group->owner?->name ?? 'penggalang dana' }}</p>
                </div>
            </div>
        @else
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold tracking-tight text-ink">Buat akun penggalang dana</h2>
                <p class="mt-1 text-sm text-ink-muted">Mulai kelola dana kelompokmu dengan transparan.</p>
            </div>
            <div class="mb-5 flex gap-2.5 rounded-input bg-neutral-tint p-3.5 text-xs leading-5 text-ink-muted">
                <span class="material-symbols-outlined !text-[18px] text-primary-dark">info</span>
                <p>Ingin bergabung sebagai <strong class="text-ink">anggota</strong>? Minta tautan undangan dari penggalang dana grup kamu, lalu daftar lewat tautan itu.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            @if ($invitation)
                <input type="hidden" name="invitation" value="{{ $invitation->token }}">
            @endif
            <x-input-error :messages="$errors->get('invitation')" />

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

            <x-primary-button class="w-full">{{ $invitation ? 'Daftar & Gabung' : 'Daftar' }}</x-primary-button>
        </form>
    @endif

    <p class="mt-6 text-center text-sm text-ink-muted">
        Sudah punya akun?
        <a href="{{ $invitation ? route('invitations.show', $invitation->token) : route('login') }}"
           class="rounded font-semibold text-primary-dark hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-primary">
            Masuk
        </a>
    </p>
</x-guest-layout>
