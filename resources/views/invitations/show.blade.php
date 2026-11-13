<x-guest-layout>
    @if ($reason || ! $group)
        <div class="text-center">
            <span class="mx-auto grid size-14 place-items-center rounded-full bg-danger-tint text-danger">
                <span class="material-symbols-outlined">link_off</span>
            </span>
            <h1 class="mt-4 text-2xl font-semibold tracking-tight">Tautan tidak dapat dipakai</h1>
            <p class="mt-1 text-sm text-ink-muted">{{ $reason ?? 'Grup ini sedang tidak aktif.' }}</p>
            <p class="mt-3 text-sm text-ink-muted">Minta tautan baru kepada penggalang dana.</p>
        </div>
    @else
        <div class="text-center">
            <x-group-avatar :group="$group" size="size-24 lg:size-28" class="mx-auto" />
            <p class="mt-4 text-sm font-bold uppercase tracking-wide text-primary-dark">Undangan bergabung</p>
            <h1 class="mt-1 text-balance break-words text-3xl font-extrabold uppercase leading-tight tracking-tight">{{ $group->name }}</h1>
            <p class="mt-1 text-sm text-ink-muted lg:text-base">
                {{ $group->category ?: 'Grup' }} · {{ $memberCount }} anggota · oleh {{ $group->owner?->name ?? '-' }}
            </p>

            @if ($group->description)
                <div class="mx-auto mt-4 flex w-full items-center justify-center gap-2 rounded-2xl bg-neutral-tint px-4 py-3 text-sm text-ink lg:w-4/5">
                    <span class="material-symbols-outlined !text-[18px] shrink-0 text-primary-dark">calendar_month</span>
                    <span class="line-clamp-2">{{ $group->description }}</span>
                </div>
            @endif
        </div>

        @if (session('error'))
            <div class="mt-5 rounded-input bg-danger-tint px-4 py-3 text-sm font-medium text-danger" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->has('invitation'))
            <div class="mt-5 rounded-input bg-danger-tint px-4 py-3 text-sm font-medium text-danger" role="alert">{{ $errors->first('invitation') }}</div>
        @endif

        <div class="mt-6 space-y-3">
            @auth
                @if (auth()->user()->hasRole('member'))
                    <form method="POST" action="{{ route('invitations.join', $invitation->token) }}">
                        @csrf
                        <x-button type="submit" size="lg" icon="login" class="w-full !rounded-full">Gabung ke Grup</x-button>
                    </form>
                    <p class="text-center text-xs text-ink-muted">Masuk sebagai {{ auth()->user()->name }}</p>
                @else
                    <div class="rounded-input bg-warn-tint px-4 py-3 text-sm leading-5 text-warn">
                        Akun <strong>{{ auth()->user()->name }}</strong> bukan akun anggota. Keluar dulu, lalu daftar atau masuk dengan akun anggota lewat tautan ini.
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-button type="submit" variant="outline" size="lg" icon="logout" class="w-full !rounded-full">Keluar dari akun ini</x-button>
                    </form>
                @endif
            @else
                <x-button :href="route('register', ['undangan' => $invitation->token])" size="lg" icon="person_add" class="w-full !rounded-full">Daftar & Gabung</x-button>
                <x-button :href="route('login')" variant="outline" size="lg" class="w-full !rounded-full !border-primary !text-primary-dark">Saya sudah punya akun</x-button>
            @endauth
        </div>
    @endif
</x-guest-layout>