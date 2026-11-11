<x-app-shell :title="$title">
    <h1 class="text-2xl font-semibold tracking-tight">{{ $title }}</h1>
    <x-card class="mt-6">
        <x-empty-state icon="construction" title="Segera hadir"
            text="Fitur ini sedang disiapkan dan akan tersedia pada tahap pengembangan berikutnya.">
            <x-button :href="route('dashboard')" variant="soft" icon="arrow_back">Kembali ke Dashboard</x-button>
        </x-empty-state>
    </x-card>
</x-app-shell>
