@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'h-[50px] w-full rounded-input border-[1.5px] border-line bg-white px-4 text-[15px] text-ink shadow-none placeholder:text-ink-muted/60 focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:bg-app']) }}>
