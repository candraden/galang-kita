@props(['icon' => 'info', 'label' => '', 'value' => '', 'sub' => null, 'tone' => 'green', 'chip' => null])
@php
    $tones = [
        'green' => 'bg-primary-tint text-primary-dark',
        'amber' => 'bg-warn-tint text-warn',
        'blue'  => 'bg-blue-100 text-blue-700',
        'gray'  => 'bg-neutral-tint text-ink-muted',
    ];
@endphp
<x-card {{ $attributes }}>
    <div class="flex items-start justify-between">
        <span class="grid size-10 place-items-center rounded-full {{ $tones[$tone] ?? $tones['green'] }}">
            <span class="material-symbols-outlined !text-[22px]">{{ $icon }}</span>
        </span>
        @if ($chip)
            <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $tones[$tone] ?? $tones['green'] }}">{{ $chip }}</span>
        @endif
    </div>
    <p class="mt-3 text-xs font-medium text-ink-muted">{{ $label }}</p>
    <p class="text-2xl font-bold tabular-nums text-ink">{{ $value }}</p>
    @if ($sub)<p class="text-xs text-ink-muted">{{ $sub }}</p>@endif
</x-card>
