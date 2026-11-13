@props(['group', 'size' => 'size-12'])
@php
    $px = [
        'size-8' => 32, 'size-10' => 40, 'size-11' => 44, 'size-12' => 48,
        'size-14' => 56, 'size-16' => 64, 'size-20' => 80, 'size-24' => 96,
    ][$size] ?? 48;
    $box = "width:{$px}px;height:{$px}px;min-width:{$px}px;max-width:{$px}px;";
@endphp
@if ($group->logo_path)
    <img src="{{ asset('storage/'.$group->logo_path) }}" alt="Logo {{ $group->name }}"
         width="{{ $px }}" height="{{ $px }}" loading="lazy"
         {{ $attributes->merge(['class' => 'shrink-0 rounded-full object-cover', 'style' => $box]) }}>
@else
    <span {{ $attributes->merge(['class' => 'grid shrink-0 place-items-center rounded-full bg-primary-tint text-primary-dark', 'style' => $box]) }}>
        <span class="material-symbols-outlined">groups</span>
    </span>
@endif