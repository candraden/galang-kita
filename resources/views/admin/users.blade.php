<x-app-shell title="Pengguna">
    <h1 class="text-2xl font-semibold tracking-tight">Pengguna</h1>
    <p class="mb-5 text-sm text-ink-muted">Kelola akun pengguna platform.</p>

    <form method="GET" class="mb-4 flex flex-col gap-2 sm:flex-row">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email"
            class="h-[50px] flex-1 rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none">
        <select name="role" class="h-[50px] rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none">
            <option value="">Semua peran</option>
            @foreach (config('galang.roles') as $key => $label)
                <option value="{{ $key }}" @selected(request('role') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <x-button type="submit" variant="navy" icon="search">Cari</x-button>
    </form>

    <x-card class="overflow-x-auto !p-0">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="border-b border-line text-xs uppercase tracking-wider text-ink-muted">
                <tr>
                    <th class="px-4 py-3 font-semibold">Pengguna</th>
                    <th class="px-4 py-3 font-semibold">Peran</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Terdaftar</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($users as $u)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="font-semibold">{{ $u->name }}</p>
                            <p class="text-xs text-ink-muted">{{ $u->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-ink-muted">
                            {{ $u->roles->map(fn ($r) => config('galang.roles.'.$r->name, $r->name))->join(', ') ?: '-' }}
                        </td>
                        <td class="px-4 py-3"><x-badge-status :status="$u->status ?? 'active'" /></td>
                        <td class="px-4 py-3 text-ink-muted">{{ $u->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            @unless ($u->hasRole('super_admin'))
                                <form method="POST" action="{{ route('admin.users.toggle', $u) }}"
                                      onsubmit="return confirm('Ubah status akun {{ addslashes($u->name) }}?')">
                                    @csrf @method('PATCH')
                                    @if (($u->status ?? 'active') === 'suspended')
                                        <x-button type="submit" variant="soft" size="sm">Aktifkan</x-button>
                                    @else
                                        <x-button type="submit" variant="danger" size="sm">Tangguhkan</x-button>
                                    @endif
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-empty-state icon="search_off" title="Pengguna tidak ditemukan" text="Coba kata kunci atau filter lain." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-card>

    <div class="mt-4">{{ $users->links() }}</div>
</x-app-shell>
