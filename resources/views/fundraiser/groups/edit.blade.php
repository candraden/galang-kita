<x-app-shell title="Ubah Grup">
    <a href="{{ route('fundraiser.groups.show', $group) }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-ink-muted hover:text-ink">
        <span class="material-symbols-outlined !text-[18px]">arrow_back</span>Kembali
    </a>
    <h1 class="text-2xl font-semibold tracking-tight">Ubah Grup</h1>
    <p class="mb-6 text-sm text-ink-muted">{{ $group->name }}</p>

    <x-card class="max-w-2xl !p-6">
        <form method="POST" action="{{ route('fundraiser.groups.update', $group) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('fundraiser.groups._form', ['group' => $group])
            <div class="mt-6 flex flex-wrap justify-end gap-2">
                <x-button :href="route('fundraiser.groups.show', $group)" variant="ghost">Batal</x-button>
                <x-button type="submit" icon="check">Simpan Perubahan</x-button>
            </div>
        </form>
    </x-card>
</x-app-shell>
