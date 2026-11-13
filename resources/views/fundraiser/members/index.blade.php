@php
    $statusMap = [
        'active'       => ['active', 'Aktif'],
        'exit_pending' => ['pending', 'Mengajukan Keluar'],
        'left'         => ['inactive', 'Telah Keluar'],
        'removed'      => ['suspended', 'Dikeluarkan'],
    ];
    $tabs = [
        'active'       => 'Aktif',
        'exit_pending' => 'Mengajukan Keluar',
        'left'         => 'Telah Keluar',
        'removed'      => 'Dikeluarkan',
        'all'          => 'Semua',
    ];
    $totalAll = $counts->sum();
    $input = 'h-[50px] rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none focus:ring-0';
@endphp
<x-app-shell title="Anggota">
    <div class="mb-5">
        <h1 class="text-2xl font-semibold tracking-tight">Anggota</h1>
        <p class="text-sm text-ink-muted">Semua anggota dari grup yang kamu kelola.</p>
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
        <x-stat-card icon="group" tone="green" label="Anggota Aktif" :value="$counts->get('active', 0)" />
        <x-stat-card icon="logout" tone="amber" label="Mengajukan Keluar" :value="$counts->get('exit_pending', 0)" />
        <x-stat-card icon="groups" tone="blue" label="Grup Dikelola" :value="$groups->count()" class="col-span-2 sm:col-span-1" />
    </div>

    @if ($groups->isEmpty())
        <x-card class="mt-6">
            <x-empty-state icon="groups" title="Belum ada grup" text="Buat grup terlebih dahulu, lalu undang anggota lewat tautan undangan.">
                <x-button :href="route('fundraiser.groups.create')" icon="add_circle">Buat Grup</x-button>
            </x-empty-state>
        </x-card>
    @else
        {{-- Filter status --}}
        <div class="mt-6 flex gap-2 overflow-x-auto pb-1" role="tablist" aria-label="Filter status anggota">
            @foreach ($tabs as $key => $label)
                @php $n = $key === 'all' ? $totalAll : $counts->get($key, 0); @endphp
                <a href="{{ request()->fullUrlWithQuery(['status' => $key, 'page' => null]) }}"
                   @class([
                       'inline-flex shrink-0 items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold transition',
                       'bg-primary text-white' => $status === $key,
                       'bg-neutral-tint text-ink hover:bg-primary-tint' => $status !== $key,
                   ]) @if ($status === $key) aria-current="true" @endif>
                    {{ $label }}
                    <span @class(['rounded-full px-1.5 text-xs tabular-nums', 'bg-white/25' => $status === $key, 'bg-white' => $status !== $key])>{{ $n }}</span>
                </a>
            @endforeach
        </div>

        {{-- Pencarian & filter grup --}}
        <form method="GET" class="mt-3 flex flex-col gap-2 sm:flex-row">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama atau email anggota" class="{{ $input }} flex-1">
            <select name="group" class="{{ $input }}" onchange="this.form.submit()">
                <option value="">Semua grup</option>
                @foreach ($groups as $g)
                    <option value="{{ $g->id }}" @selected($groupId === $g->id)>{{ $g->name }}</option>
                @endforeach
            </select>
            <x-button type="submit" variant="navy" icon="search">Cari</x-button>
        </form>

        {{-- Daftar --}}
        <x-card class="mt-4 divide-y divide-line !p-0">
            @forelse ($members as $m)
                @php [$badge, $badgeLabel] = $statusMap[$m->status] ?? ['unpaid', $m->status]; @endphp
                <div class="flex flex-wrap items-center gap-3 px-4 py-3.5">
                    <span class="grid size-11 shrink-0 place-items-center rounded-full bg-primary-tint font-bold text-primary-dark">
                        {{ strtoupper(mb_substr($m->user->name, 0, 1)) }}
                    </span>

                    <div class="min-w-0 flex-1 basis-48">
                        <p class="truncate font-semibold">{{ $m->user->name }}</p>
                        <p class="truncate text-xs text-ink-muted">{{ $m->user->email }}</p>
                        <p class="mt-0.5 truncate text-xs text-ink-muted md:hidden">
                            {{ $m->group->name }} · {{ $m->joined_at?->translatedFormat('d M Y') ?? '-' }}
                        </p>
                    </div>

                    <div class="hidden w-48 min-w-0 md:block">
                        <a href="{{ route('fundraiser.groups.show', $m->group) }}" class="block truncate text-sm font-medium text-ink hover:text-primary-dark">{{ $m->group->name }}</a>
                        <p class="text-xs text-ink-muted">Bergabung {{ $m->joined_at?->translatedFormat('d M Y') ?? '-' }}</p>
                    </div>

                    <x-badge-status :status="$badge" :label="$badgeLabel" />

                    @if (in_array($m->status, ['active', 'exit_pending'], true))
                        <form method="POST" action="{{ route('fundraiser.members.remove', $m) }}"
                              onsubmit="return confirm('Keluarkan {{ addslashes($m->user->name) }} dari grup {{ addslashes($m->group->name) }}?')">
                            @csrf @method('PATCH')
                            <x-button type="submit" variant="danger" size="sm" icon="person_remove">Keluarkan</x-button>
                        </form>
                    @elseif ($m->status === 'removed')
                        <form method="POST" action="{{ route('fundraiser.members.restore', $m) }}"
                              onsubmit="return confirm('Pulihkan {{ addslashes($m->user->name) }} sebagai anggota grup {{ addslashes($m->group->name) }}?')">
                            @csrf @method('PATCH')
                            <x-button type="submit" variant="soft" size="sm" icon="person_add">Pulihkan</x-button>
                        </form>
                    @endif
                </div>
            @empty
                <x-empty-state icon="group_off"
                    :title="$search !== '' ? 'Anggota tidak ditemukan' : 'Belum ada anggota'"
                    :text="$search !== '' ? 'Coba kata kunci atau filter lain.' : 'Bagikan tautan undangan dari halaman detail grup agar anggota bisa bergabung.'">
                    @if ($search === '')
                        <x-button :href="route('fundraiser.groups.index')" variant="soft" icon="add_link">Kelola Tautan Undangan</x-button>
                    @endif
                </x-empty-state>
            @endforelse
        </x-card>

        <div class="mt-4">{{ $members->links() }}</div>
    @endif
</x-app-shell>
