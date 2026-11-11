@props(['dark' => false])
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 font-bold text-lg']) }}>
    <img src="{{ asset('images/logo-256.png') }}" alt="" class="size-9 object-contain" width="36" height="36">
    <span class="{{ $dark ? 'text-white' : 'text-navy' }}">Galang <span class="text-primary-dark">Kita</span></span>
</span>
