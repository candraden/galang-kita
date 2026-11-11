<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex h-[52px] items-center justify-center rounded-full bg-primary px-6 text-sm font-semibold text-white transition hover:bg-primary-dark active:scale-[0.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 disabled:opacity-60']) }}>
    {{ $slot }}
</button>
