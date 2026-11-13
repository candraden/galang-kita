<x-app-shell title="Dashboard Penggalang Dana">
    @php
        $stats = [
            ['icon' => 'account_balance_wallet', 'tone' => 'bg-primary-tint text-primary-dark', 'label' => 'Total Dana Terkumpul', 'value' => '-', 'sub' => 'Fitur menyusul'],
            ['icon' => 'groups', 'tone' => 'bg-blue-100 text-blue-700', 'label' => 'Total Anggota Aktif', 'value' => $totalMembers, 'sub' => $groups->count().' grup dikelola'],
            ['icon' => 'folder', 'tone' => 'bg-violet-100 text-violet-700', 'label' => 'Program Aktif', 'value' => '-', 'sub' => 'Fitur menyusul'],
            ['icon' => 'schedule', 'tone' => 'bg-warn-tint text-warn', 'label' => 'Menunggu Verifikasi', 'value' => '-', 'sub' => 'Fitur menyusul'],
        ];
    @endphp

    {{-- Sapaan --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight lg:text-3xl">Selamat datang, {{ auth()->user()->name }} 👋</h1>
        <p class="mt-1 text-sm text-ink-muted lg:text-base">Berikut ringkasan aktivitas penggalangan dana kamu.</p>
    </div>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
        @foreach ($stats as $s)
            <x-card class="flex flex-col items-start gap-3 !p-4 sm:flex-row sm:items-center sm:gap-4 sm:!p-5">
                <span class="grid size-11 shrink-0 place-items-center rounded-2xl sm:size-14 {{ $s['tone'] }}">
                    <span class="material-symbols-outlined !text-[24px] sm:!text-[28px]">{{ $s['icon'] }}</span>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs font-medium text-ink-muted sm:text-sm">{{ $s['label'] }}</p>
                    <p class="text-2xl font-bold leading-tight tabular-nums">{{ $s['value'] }}</p>
                    <p class="truncate text-xs text-ink-muted">{{ $s['sub'] }}</p>
                </div>
            </x-card>
        @endforeach
    </div>

    {{-- Grafik + Grup Saya --}}
    <div class="mt-4 grid gap-4 lg:grid-cols-3">
        <x-card class="!p-5 lg:col-span-2">
            <h2 class="flex items-center gap-2.5 text-base font-semibold">
                <span class="grid size-8 place-items-center rounded-lg bg-primary-tint text-primary-dark">
                    <span class="material-symbols-outlined !text-[20px]">bar_chart</span>
                </span>
                Perkembangan Dana
            </h2>
            <div class="relative mt-4 h-56 overflow-hidden rounded-2xl bg-neutral-tint/60">
                @foreach (range(0, 4) as $n)
                    <div class="absolute inset-x-5 border-t border-dashed border-line" style="top: {{ 14 + $n * 18 }}%"></div>
                @endforeach
                <div class="absolute inset-0 grid place-items-center px-6 text-center">
                    <div>
                        <span class="material-symbols-outlined !text-[32px] text-ink-muted">query_stats</span>
                        <p class="mt-1 text-sm font-semibold">Belum ada data</p>
                        <p class="text-xs text-ink-muted">Grafik muncul setelah ada pembayaran terverifikasi.</p>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="!p-5">
            <div class="flex items-center justify-between">
                <h2 class="flex items-center gap-2.5 text-base font-semibold">
                    <span class="grid size-8 place-items-center rounded-lg bg-primary-tint text-primary-dark">
                        <span class="material-symbols-outlined !text-[20px]">groups</span>
                    </span>
                    Grup Saya
                </h2>
                <a href="{{ route('fundraiser.groups.index') }}" class="text-sm font-semibold text-primary-dark hover:underline">Lihat Semua →</a>
            </div>

            @forelse ($groups->take(4) as $g)
                <a href="{{ route('fundraiser.groups.show', $g) }}" class="-mx-2 mt-2 flex items-center gap-3 rounded-2xl px-2 py-2.5 transition hover:bg-neutral-tint">
                    <x-group-avatar :group="$g" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-semibold">{{ $g->name }}</p>
                        <p class="truncate text-xs text-ink-muted">{{ $g->category ?: 'Tanpa kategori' }} · {{ $g->members_count }} anggota</p>
                    </div>
                    <x-badge-status :status="$g->status" />
                </a>
            @empty
                <x-empty-state icon="groups" title="Belum ada grup" text="Buat grup pertama kamu untuk mulai mengelola iuran.">
                    <x-button :href="route('fundraiser.groups.create')" size="sm" icon="add_circle">Buat Grup</x-button>
                </x-empty-state>
            @endforelse
        </x-card>
    </div>

    {{-- Aktivitas + Banner --}}
    <div class="mt-4 grid gap-4 lg:grid-cols-3">
        <x-card class="!p-5 lg:col-span-2">
            <h2 class="flex items-center gap-2.5 text-base font-semibold">
                <span class="grid size-8 place-items-center rounded-lg bg-primary-tint text-primary-dark">
                    <span class="material-symbols-outlined !text-[20px]">schedule</span>
                </span>
                Aktivitas Terbaru
            </h2>
            <x-empty-state icon="history" title="Belum ada aktivitas" text="Pembayaran dan anggota baru akan muncul di sini." />
        </x-card>

        <div class="relative flex flex-col justify-between gap-5 overflow-hidden rounded-card bg-gradient-to-br from-primary-tint to-emerald-50 p-6">
            <span class="material-symbols-outlined pointer-events-none absolute -bottom-6 -right-4 !text-[120px] text-primary/15" aria-hidden="true">volunteer_activism</span>
            <div class="relative">
                <h2 class="text-lg font-bold leading-snug">Bersama, kita bisa mencapai lebih banyak!</h2>
                <p class="mt-1 text-sm text-ink-muted">Kelola penggalangan dana dengan mudah dan transparan.</p>
            </div>
            <div class="relative">
                <x-button :href="route('fundraiser.groups.index')" size="sm">
                    Kelola Grup Saya <span class="material-symbols-outlined !text-[18px]">arrow_forward</span>
                </x-button>
            </div>
        </div>
    </div>
</x-app-shell>