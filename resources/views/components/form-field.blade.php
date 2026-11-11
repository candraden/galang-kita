@props(['label', 'name', 'hint' => null, 'required' => false])
<div>
    <label for="{{ $name }}" class="mb-1.5 block text-xs font-medium text-ink-muted">
        {{ $label }}@if ($required)<span class="text-danger"> *</span>@endif
    </label>
    {{ $slot }}
    @if ($hint)<p class="mt-1 text-xs text-ink-muted">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>@enderror
</div>
