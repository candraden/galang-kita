<x-app-shell title="Dashboard Penggalang Dana">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Halo, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-ink-muted">Kelola grup dan pantau pengumpulan dana kamu.</p>
    </div>

    <x-hero-card label="Total Anggota Aktif" :value="$totalMembers" :note="$groups->count().' grup dikelola'">
        <x-button :href="route('fundraiser.groups.create')" variant="primary" size="sm" icon="add_circle">Buat Grup</x-button>
        <x-button :href="route('fundraiser.groups.index')" variant="on-dark" size="sm" icon="groups">Grup Saya</x-button>
        <x-button :href="route('placeholder', 'verifikasi-pembayaran')" variant="on-dark" size="sm" icon="fact_check">Verifikasi</x-button>
    </x-hero-card>

    <div class="mt-4 grid grid-cols-2 gap-4">
        <x-stat-card icon="schedule" tone="amber" chip="Segera" label="Menunggu Verifikasi" value="-" sub="Fitur menyusul" />
        <x-stat-card icon="pending_actions" tone="blue" chip="Segera" label="Belum Membayar" value="-" sub="Fitur menyusul" />
    </div>

    <div class="mt-8 flex items-center justify-between">
        <h2 class="text-lg font-semibold">Grup Saya</h2>
        <a href="{{ route('fundraiser.groups.index') }}" class="text-sm font-semibold text-primary-dark">Semua →</a>
    </div>
    <div class="mt-3 space-y-3">
        @forelse ($groups->take(5) as $g)
            <a href="{{ route('fundraiser.groups.show', $g) }}" class="block">
                <x-card class="flex items-center gap-4 transition hover:border-primary">
                    <x-group-avatar :group="$g" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-semibold">{{ $g->name }}</p>
                        <p class="truncate text-xs text-ink-muted">{{ $g->category ?: 'Tanpa kategori' }} · {{ $g->members_count }} anggota</p>
                    </div>
                    <x-badge-status :status="$g->status" />
                </x-card>
            </a>
        @empty
            <x-card>
                <x-empty-state icon="groups" title="Belum ada grup" text="Buat grup pertama kamu untuk mulai mengelola iuran.">
                    <x-button :href="route('fundraiser.groups.create')" icon="add_circle">Buat Grup</x-button>
                </x-empty-state>
            </x-card>
        @endforelse
    </div>
</x-app-shell>
