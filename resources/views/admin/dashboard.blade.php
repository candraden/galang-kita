<x-app-shell title="Dashboard Admin">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Dashboard Admin</h1>
        <p class="text-sm text-ink-muted">Ringkasan aktivitas platform Galang Kita.</p>
    </div>

    <x-hero-card label="Total Pengguna Terdaftar" :value="number_format($totalUsers, 0, ',', '.')" :note="$newUsers.' pengguna baru dalam 7 hari terakhir'">
        <x-button :href="route('admin.users')" variant="primary" size="sm" icon="group">Kelola Pengguna</x-button>
        <x-button :href="route('admin.groups')" variant="on-dark" size="sm" icon="groups">Lihat Grup</x-button>
    </x-hero-card>

    <div class="mt-4 grid grid-cols-2 gap-4 lg:grid-cols-4">
        <x-stat-card icon="group_add" tone="blue" label="Pengguna Baru (7 hari)" :value="$newUsers" />
        <x-stat-card icon="groups" tone="green" label="Total Grup" :value="$totalGroups" />
        <x-stat-card icon="check_circle" tone="green" label="Grup Aktif" :value="$activeGroups" />
        <x-stat-card icon="remove_circle" tone="gray" label="Grup Nonaktif" :value="$totalGroups - $activeGroups" />
    </div>

    <div class="mt-8 flex items-center justify-between">
        <h2 class="text-lg font-semibold">Pengguna Terbaru</h2>
        <a href="{{ route('admin.users') }}" class="text-sm font-semibold text-primary-dark">Semua →</a>
    </div>
    <x-card class="mt-3 divide-y divide-line !p-0">
        @forelse ($latestUsers as $u)
            <div class="flex items-center gap-3 px-4 py-3">
                <span class="grid size-11 place-items-center rounded-full bg-primary-tint font-bold text-primary-dark">{{ strtoupper(mb_substr($u->name, 0, 1)) }}</span>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold">{{ $u->name }}</p>
                    <p class="truncate text-xs text-ink-muted">{{ $u->email }}</p>
                </div>
                <span class="text-xs text-ink-muted">{{ $u->created_at->diffForHumans() }}</span>
            </div>
        @empty
            <x-empty-state icon="group" title="Belum ada pengguna" />
        @endforelse
    </x-card>
</x-app-shell>
