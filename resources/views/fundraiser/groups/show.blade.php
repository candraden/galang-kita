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

    <x-card class="mt-4">
        <h2 class="text-lg font-semibold">Tentang Grup</h2>
        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-ink-muted">{{ $group->description ?: 'Belum ada deskripsi.' }}</p>
    </x-card>

    {{-- Tautan undangan --}}
    @php
        $usable = $invitation && $invitation->isUsable();
        $inviteUrl = $usable ? route('invitations.show', $invitation->token) : null;
    @endphp
    <x-card class="mt-4">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold">Tautan Undangan</h2>
                <p class="text-sm text-ink-muted">Anggota hanya bisa bergabung lewat tautan ini.</p>
            </div>
            @if ($usable)
                <x-badge-status status="active" />
            @endif
        </div>

        @if ($usable)
            <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                <input id="invite-url" type="text" readonly value="{{ $inviteUrl }}"
                       class="h-[50px] flex-1 rounded-input border-[1.5px] border-line bg-neutral-tint px-4 text-sm text-ink focus:border-primary focus:outline-none focus:ring-0">
                <x-button type="button" icon="content_copy" id="copy-invite">Salin Tautan</x-button>
            </div>
            <p id="copy-feedback" class="mt-2 hidden text-xs font-medium text-primary-dark">Tautan disalin.</p>
            <ul class="mt-3 flex flex-wrap gap-x-5 gap-y-1 text-xs text-ink-muted">
                <li>Dipakai <strong class="text-ink">{{ $invitation->used_count }}</strong>{{ $invitation->max_uses ? ' dari '.$invitation->max_uses : '' }} kali</li>
                <li>Berlaku: <strong class="text-ink">{{ $invitation->expires_at ? 'sampai '.$invitation->expires_at->translatedFormat('d M Y H:i') : 'tanpa batas waktu' }}</strong></li>
            </ul>
            <form method="POST" action="{{ route('fundraiser.groups.invitations.deactivate', [$group, $invitation]) }}" class="mt-4"
                  onsubmit="return confirm('Nonaktifkan tautan ini? Tautan yang sudah dibagikan tidak akan bisa dipakai lagi.')">
                @csrf @method('PATCH')
                <x-button type="submit" variant="danger" size="sm" icon="link_off">Nonaktifkan Tautan</x-button>
            </form>
        @else
            <p class="mt-4 rounded-input bg-neutral-tint px-4 py-3 text-sm text-ink-muted">
                {{ $invitation ? $invitation->unusableReason() : 'Belum ada tautan aktif.' }} Buat tautan baru untuk mengundang anggota.
            </p>
        @endif

        <details class="mt-4 rounded-input border border-line" @if ($errors->hasAny(['expires_in', 'max_uses'])) open @endif>
            <summary class="cursor-pointer select-none px-4 py-3 text-sm font-semibold text-primary-dark">
                {{ $usable ? 'Buat tautan baru (mengganti yang aktif)' : 'Buat tautan baru' }}
            </summary>
            <form method="POST" action="{{ route('fundraiser.groups.invitations.store', $group) }}" class="space-y-4 border-t border-line p-4">
                @csrf
                <x-form-field label="Masa berlaku" name="expires_in">
                    <select id="expires_in" name="expires_in" class="h-[50px] w-full rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none focus:ring-0">
                        <option value="">Tanpa batas waktu</option>
                        <option value="1" @selected(old('expires_in') === '1')>1 hari</option>
                        <option value="7" @selected(old('expires_in') === '7')>7 hari</option>
                        <option value="30" @selected(old('expires_in') === '30')>30 hari</option>
                    </select>
                </x-form-field>
                <x-form-field label="Batas penggunaan" name="max_uses" hint="Kosongkan jika tidak dibatasi.">
                    <input id="max_uses" name="max_uses" type="number" min="1" max="10000" value="{{ old('max_uses') }}" placeholder="Contoh: 50"
                           class="h-[50px] w-full rounded-input border-[1.5px] border-line bg-white px-4 text-sm focus:border-primary focus:outline-none focus:ring-0">
                </x-form-field>
                <x-button type="submit" icon="add_link">Buat Tautan</x-button>
            </form>
        </details>
    </x-card>

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
            <x-empty-state icon="group_add" title="Belum ada anggota" text="Bagikan tautan undangan di atas agar anggota bisa bergabung." />
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
        <p class="mt-1 text-sm text-ink-muted">Grup <strong>{{ $group->name }}</strong> akan disembunyikan dari daftar dan tautan undangannya tidak bisa dipakai lagi.</p>
        <form method="POST" action="{{ route('fundraiser.groups.destroy', $group) }}" class="mt-6 flex justify-end gap-2">
            @csrf @method('DELETE')
            <x-button type="button" variant="ghost" onclick="this.closest('dialog').close()">Batal</x-button>
            <x-button type="submit" variant="danger" icon="delete">Ya, Hapus</x-button>
        </form>
    </dialog>

    <script>
        (function () {
            var btn = document.getElementById('copy-invite');
            if (!btn) return;
            btn.addEventListener('click', function () {
                var input = document.getElementById('invite-url');
                var done = function () {
                    var fb = document.getElementById('copy-feedback');
                    fb.classList.remove('hidden');
                    setTimeout(function () { fb.classList.add('hidden'); }, 2000);
                };
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(input.value).then(done);
                } else {
                    input.select();
                    document.execCommand('copy');
                    done();
                }
            });
        })();
    </script>
</x-app-shell>
