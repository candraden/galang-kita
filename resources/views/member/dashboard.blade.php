<x-app-shell title="Dashboard Anggota">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Halo, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-ink-muted">Pantau grup dan kewajiban kamu di sini.</p>
    </div>

    <x-hero-card label="Grup yang Diikuti" :value="$memberships->count()" note="Kewajiban pembayaran segera tersedia">
        <x-button :href="route('placeholder', 'kewajiban-saya')" variant="primary" size="sm" icon="receipt_long">Kewajiban Saya</x-button>
        <x-button :href="route('placeholder', 'riwayat-pembayaran')" variant="on-dark" size="sm" icon="history">Riwayat</x-button>
    </x-hero-card>

    <div class="mt-4 grid grid-cols-2 gap-4">
        <x-stat-card icon="pending_actions" tone="blue" chip="Segera" label="Belum Dibayar" value="-" sub="Fitur menyusul" />
        <x-stat-card icon="check_circle" tone="green" chip="Segera" label="Sudah Lunas" value="-" sub="Fitur menyusul" />
    </div>

    <h2 class="mt-8 text-lg font-semibold">Grup Saya</h2>
    <div class="mt-3 space-y-3">
        @forelse ($memberships as $m)
            <x-card class="flex items-center gap-4">
                <span class="grid size-12 shrink-0 place-items-center rounded-full bg-primary-tint text-primary-dark">
                    <span class="material-symbols-outlined">groups</span>
                </span>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold">{{ $m->group->name }}</p>
                    <p class="truncate text-xs text-ink-muted">Penggalang: {{ $m->group->owner?->name ?? '-' }}</p>
                </div>
                <x-badge-status :status="$m->status === 'active' ? 'active' : 'inactive'" />
            </x-card>
        @empty
            <x-card>
                <x-empty-state icon="link" title="Belum bergabung ke grup" text="Minta tautan undangan dari penggalang dana untuk bergabung." />
            </x-card>
        @endforelse
    </div>
</x-app-shell>
