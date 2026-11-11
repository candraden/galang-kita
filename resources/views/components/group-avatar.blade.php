@props(['group', 'size' => 'size-12'])
@if ($group->logo_path)
    <img src="{{ asset('storage/'.$group->logo_path) }}" alt="Logo {{ $group->name }}"
         {{ $attributes->merge(['class' => "$size shrink-0 rounded-full object-cover"]) }}>
@else
    <span {{ $attributes->merge(['class' => "$size grid shrink-0 place-items-center rounded-full bg-primary-tint text-primary-dark"]) }}>
        <span class="material-symbols-outlined">groups</span>
    </span>
@endif
