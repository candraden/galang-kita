@props(['icon' => 'inbox', 'title' => 'Belum ada data', 'text' => null])
<div class="flex flex-col items-center text-center py-10 px-4">
    <span class="grid size-14 place-items-center rounded-full bg-neutral-tint text-ink-muted">
        <span class="material-symbols-outlined !text-[28px]">{{ $icon }}</span>
    </span>
    <p class="mt-3 text-base font-semibold text-ink">{{ $title }}</p>
    @if ($text)<p class="mt-1 max-w-xs text-sm text-ink-muted">{{ $text }}</p>@endif
    @if (trim((string) $slot) !== '')<div class="mt-4">{{ $slot }}</div>@endif
</div>
