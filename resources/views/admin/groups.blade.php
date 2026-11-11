<x-app-shell title="Grup">
    <h1 class="text-2xl font-semibold tracking-tight">Grup</h1>
    <p class="mb-5 text-sm text-ink-muted">Pengawasan seluruh grup di platform.</p>

    <form method="GET" class="mb-4 flex gap-2">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama grup"
            class="h-[50px] flex-1 rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none">
        <x-button type="submit" variant="navy" icon="search">Cari</x-button>
    </form>

    <x-card class="overflow-x-auto !p-0">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="border-b border-line text-xs uppercase tracking-wider text-ink-muted">
                <tr>
                    <th class="px-4 py-3 font-semibold">Grup</th>
                    <th class="px-4 py-3 font-semibold">Pemilik</th>
                    <th class="px-4 py-3 font-semibold">Anggota</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($groups as $g)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="font-semibold">{{ $g->name }}</p>
                            <p class="text-xs text-ink-muted">{{ $g->category ?: 'Tanpa kategori' }}</p>
                        </td>
                        <td class="px-4 py-3 text-ink-muted">{{ $g->owner?->name ?? '-' }}</td>
                        <td class="px-4 py-3 tabular-nums">{{ $g->members_count }}</td>
                        <td class="px-4 py-3"><x-badge-status :status="$g->status ?? 'active'" /></td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.groups.toggle', $g) }}"
                                  onsubmit="return confirm('Ubah status grup {{ addslashes($g->name) }}?')">
                                @csrf @method('PATCH')
                                @if (($g->status ?? 'active') === 'active')
                                    <x-button type="submit" variant="danger" size="sm">Nonaktifkan</x-button>
                                @else
                                    <x-button type="submit" variant="soft" size="sm">Aktifkan</x-button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-empty-state icon="groups" title="Belum ada grup" text="Grup yang dibuat penggalang dana akan muncul di sini." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-card>

    <div class="mt-4">{{ $groups->links() }}</div>
</x-app-shell>
