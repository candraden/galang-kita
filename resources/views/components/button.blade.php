@props(['variant' => 'primary', 'href' => null, 'type' => 'button', 'icon' => null, 'size' => 'md'])
@php
    $sizes = ['md' => 'h-12 px-6 text-sm', 'sm' => 'h-10 px-4 text-sm', 'lg' => 'h-[52px] px-8 text-base'];
    $variants = [
        'primary'   => 'bg-primary text-white hover:bg-primary-dark',
        'navy'      => 'bg-navy text-white hover:bg-navy/90',
        'outline'   => 'border-[1.5px] border-primary text-primary-dark hover:bg-primary-tint',
        'soft'      => 'bg-primary-tint text-primary-dark hover:bg-primary-tint/70',
        'danger'    => 'bg-danger-tint text-danger hover:bg-danger-tint/70',
        'ghost'     => 'text-ink-muted hover:bg-neutral-tint',
        'on-dark'   => 'bg-white/10 text-white hover:bg-white/20',
    ];
    $class = 'inline-flex items-center justify-center gap-2 rounded-full font-semibold whitespace-nowrap transition active:scale-[0.98] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary '
        .($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['primary']);
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        @if ($icon)<span class="material-symbols-outlined !text-[20px]">{{ $icon }}</span>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
        @if ($icon)<span class="material-symbols-outlined !text-[20px]">{{ $icon }}</span>@endif
        {{ $slot }}
    </button>
@endif
