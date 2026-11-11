<x-app-shell :title="$group->name">
    <a href="{{ route('fundraiser.groups.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-ink-muted hover:text-ink">
        <span class="material-symbols-outlined !text-[18px]">arrow_back</span>Grup Saya
    </a>

    <div class="mb-5 flex flex-wrap items-center gap-4">
        <x-group-avatar :group="$group" size="size-16" />
        <div class="min-w-0 flex-1">
            <h1 class="truncate text-2xl font-semibold tracking-tight">{{ $group->name }}</h1>
            <p class="text-sm text-ink-muted">{{ $group->category ?: 'Tanpa kategori' }}</p>
        </div>
        <x-badge-status :status="$group->status" />
    </div>

    <x-hero-card label="Anggota Aktif" :value="$members->count()" note="Dibuat {{ $group->created_at->translatedFormat('d F Y') }}">
        <x-button :href="route('fundraiser.groups.edit', $group)" variant="primary" size="sm" icon="edit">Ubah</x-button>
        <x-button type="button" variant="on-dark" size="sm" icon="delete"
                  onclick="document.getElementById('delete-dialog').showModal()">Hapus</x-button>
    </x-hero-card>

    <div class="mt-4 grid gap-4 lg:grid-cols-3">
        <x-card class="lg:col-span-2">
            <h2 class="text-lg font-semibold">Tentang Grup</h2>
            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-ink-muted">{{ $group->description ?: 'Belum ada deskripsi.' }}</p>
        </x-card>

        <x-card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Tautan Undangan</h2>
                <span class="rounded-full bg-neutral-tint px-2 py-0.5 text-[10px] font-semibold text-ink-muted">Segera</span>
            </div>
            <p class="mt-2 text-sm text-ink-muted">Bagikan tautan agar anggota bisa bergabung sendiri. Fitur ini menyusul.</p>
        </x-card>
    </div>

    <h2 class="mt-8 text-lg font-semibold">Anggota</h2>
    <x-card class="mt-3 divide-y divide-line !p-0">
        @forelse ($members as $m)
            <div class="flex items-center gap-3 px-4 py-3">
                <span class="grid size-11 place-items-center rounded-full bg-primary-tint font-bold text-primary-dark">
                    {{ strtoupper(mb_substr($m->user->name, 0, 1)) }}
                </span>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold">{{ $m->user->name }}</p>
                    <p class="truncate text-xs text-ink-muted">{{ $m->user->email }}</p>
                </div>
                <span class="text-xs text-ink-muted">Bergabung {{ $m->joined_at?->translatedFormat('d M Y') ?? '-' }}</span>
            </div>
        @empty
            <x-empty-state icon="group_add" title="Belum ada anggota" text="Anggota akan muncul di sini setelah bergabung lewat tautan undangan." />
        @endforelse
    </x-card>

    <h2 class="mt-8 text-lg font-semibold">Program Dana</h2>
    <x-card class="mt-3">
        <x-empty-state icon="savings" title="Program dana segera hadir" text="Kamu akan bisa membuat iuran, kas, atau donasi di dalam grup ini." />
    </x-card>

    {{-- Konfirmasi hapus --}}
    <dialog id="delete-dialog" class="m-auto w-[90%] max-w-sm rounded-hero p-6 shadow-sheet backdrop:bg-navy/40">
        <span class="grid size-12 place-items-center rounded-full bg-danger-tint text-danger"><span class="material-symbols-outlined">warning</span></span>
        <h3 class="mt-4 text-lg font-semibold">Hapus grup ini?</h3>
        <p class="mt-1 text-sm text-ink-muted">Grup <strong>{{ $group->name }}</strong> akan disembunyikan dari daftar. Tindakan ini tidak dapat dibatalkan dari aplikasi.</p>
        <form method="POST" action="{{ route('fundraiser.groups.destroy', $group) }}" class="mt-6 flex justify-end gap-2">
            @csrf @method('DELETE')
            <x-button type="button" variant="ghost" onclick="this.closest('dialog').close()">Batal</x-button>
            <x-button type="submit" variant="danger" icon="delete">Ya, Hapus</x-button>
        </form>
    </dialog>
</x-app-shell>
