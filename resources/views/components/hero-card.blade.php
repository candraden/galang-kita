@props(['label' => '', 'value' => '', 'note' => null])
<div {{ $attributes->merge(['class' => 'relative overflow-hidden bg-navy text-white rounded-hero shadow-hero p-6']) }}>
    <svg class="absolute -top-10 -right-10 w-52 h-52 text-white opacity-10 pointer-events-none" viewBox="0 0 200 200" fill="none" stroke="currentColor" aria-hidden="true">
        <circle cx="100" cy="100" r="30"/><circle cx="100" cy="100" r="52"/><circle cx="100" cy="100" r="74"/><circle cx="100" cy="100" r="96"/>
    </svg>
    <div class="relative">
        <p class="text-xs font-medium uppercase tracking-wider text-white/70">{{ $label }}</p>
        <p class="mt-1 text-[32px] leading-10 font-bold tracking-tight tabular-nums">{{ $value }}</p>
        @if ($note)
            <span class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-primary-tint">
                <span class="size-1.5 rounded-full bg-primary"></span>{{ $note }}
            </span>
        @endif
        @if (trim((string) $slot) !== '')
            <div class="mt-5 flex flex-wrap gap-2">{{ $slot }}</div>
        @endif
    </div>
</div>
