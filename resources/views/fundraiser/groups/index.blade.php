<x-app-shell title="Grup Saya">
    <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Grup Saya</h1>
            <p class="text-sm text-ink-muted">Semua grup yang kamu kelola.</p>
        </div>
        <x-button :href="route('fundraiser.groups.create')" icon="add_circle">Buat Grup</x-button>
    </div>

    <form method="GET" class="mb-5 flex flex-col gap-2 sm:flex-row">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama grup"
               class="h-[50px] flex-1 rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none focus:ring-0">
        <select name="status" class="h-[50px] rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none focus:ring-0">
            <option value="">Semua status</option>
            <option value="active" @selected(request('status') === 'active')>Aktif</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
        </select>
        <x-button type="submit" variant="navy" icon="search">Cari</x-button>
    </form>

    @if ($groups->isEmpty())
        <x-card>
            <x-empty-state icon="groups" title="Belum ada grup"
                :text="request()->hasAny(['q', 'status']) ? 'Tidak ada grup yang cocok dengan pencarian.' : 'Buat grup pertama kamu untuk mulai mengelola iuran.'">
                <x-button :href="route('fundraiser.groups.create')" icon="add_circle">Buat Grup</x-button>
            </x-empty-state>
        </x-card>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($groups as $g)
                <a href="{{ route('fundraiser.groups.show', $g) }}" class="block">
                    <x-card class="h-full transition hover:border-primary">
                        <div class="flex items-start justify-between gap-3">
                            <x-group-avatar :group="$g" />
                            <x-badge-status :status="$g->status" />
                        </div>
                        <h2 class="mt-3 truncate text-base font-semibold">{{ $g->name }}</h2>
                        <p class="text-xs text-ink-muted">{{ $g->category ?: 'Tanpa kategori' }}</p>
                        <p class="mt-2 line-clamp-2 min-h-10 text-sm text-ink-muted">{{ $g->description ?: 'Belum ada deskripsi.' }}</p>
                        <div class="mt-3 flex items-center gap-1.5 border-t border-line pt-3 text-sm text-ink-muted">
                            <span class="material-symbols-outlined !text-[18px]">group</span>
                            <span class="tabular-nums">{{ $g->members_count }}</span> anggota
                        </div>
                    </x-card>
                </a>
            @endforeach
        </div>
        <div class="mt-5">{{ $groups->links() }}</div>
    @endif
</x-app-shell>
