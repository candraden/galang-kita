<x-app-shell title="Buat Grup">
    <a href="{{ route('fundraiser.groups.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-ink-muted hover:text-ink">
        <span class="material-symbols-outlined !text-[18px]">arrow_back</span>Kembali
    </a>
    <h1 class="text-2xl font-semibold tracking-tight">Buat Grup Baru</h1>
    <p class="mb-6 text-sm text-ink-muted">Grup adalah ruang untuk mengelola anggota dan program dana.</p>

    <x-card class="max-w-2xl !p-6">
        <form method="POST" action="{{ route('fundraiser.groups.store') }}" enctype="multipart/form-data">
            @csrf
            @include('fundraiser.groups._form', ['group' => null])
            <div class="mt-6 flex flex-wrap justify-end gap-2">
                <x-button :href="route('fundraiser.groups.index')" variant="ghost">Batal</x-button>
                <x-button type="submit" icon="check">Simpan Grup</x-button>
            </div>
        </form>
    </x-card>
</x-app-shell>
