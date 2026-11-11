@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-medium text-ink-muted']) }}>
    {{ $value ?? $slot }}
</label>
