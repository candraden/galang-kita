@props(['dark' => false])
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 font-bold text-lg']) }}>
    <span class="grid size-9 place-items-center rounded-xl bg-primary text-white">
        <span class="material-symbols-outlined !text-[20px]">volunteer_activism</span>
    </span>
    <span class="{{ $dark ? 'text-white' : 'text-navy' }}">Galang <span class="text-primary-dark">Kita</span></span>
</span>