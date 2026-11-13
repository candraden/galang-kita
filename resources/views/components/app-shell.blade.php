@props(['title' => 'Dashboard'])
@php
    $user  = auth()->user();
    $role  = $user->currentRole();
    $items = collect(config("galang.menus.$role", []))->map(function ($i) {
        $url = route($i['route'], $i['params'] ?? []);
        return $i + [
            'url'    => $url,
            'active' => isset($i['match']) ? request()->is($i['match']) : url()->current() === $url,
        ];
    });
    $roleLabel = config("galang.roles.$role", '');
    $initial   = strtoupper(mb_substr($user->name, 0, 1));
    $bottom    = $items->take(4);
    $svgIcons  = [
        // ikon custom (outline, 24x24). Pakai di config/galang.php: 'icon' => 'ayam'
        'ayam' => '<path d="M14.7 9.4C12 10.2 9.5 9.2 8 7C7.2 5.8 6.2 4.6 4.8 4C4.2 7.5 4.8 10 6 12C6 15.8 8 19 11.5 19H14C16.8 19 18.4 16.5 18.4 13.5C18.4 11.5 18 10.2 18.2 9.1"/><circle cx="16.4" cy="7.2" r="2.6"/><path d="M14.9 5.2C14.3 3.8 15.2 2.8 16.1 3.4C16.5 2.3 17.8 2.4 18 3.5C18.9 3.4 19.4 4.5 18.5 5.4"/><path d="M18.9 6.8L21.3 7.8L18.8 8.7"/><path d="M9 13C10.5 15.5 13.8 15.5 15.4 13"/><circle cx="17.4" cy="6.9" r=".45" fill="currentColor" stroke="none"/>',
    ];
    $icon = fn (string $name, string $mat, int $px, string $extra = '') => new \Illuminate\Support\HtmlString(
        isset($svgIcons[$name])
            ? '<svg class="shrink-0 '.$extra.'" width="'.$px.'" height="'.$px.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$svgIcons[$name].'</svg>'
            : '<span class="material-symbols-outlined '.$mat.' '.$extra.'">'.e($name).'</span>'
    );
    $navGroups = $items->groupBy(fn ($i) => $i['group'] ?? '');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · Galang Kita</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-app font-sans text-ink antialiased">

    {{-- Sidebar desktop --}}
    <aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-line bg-white px-4 pb-4 pt-5 lg:flex">
        <a href="{{ route('dashboard') }}" class="px-2 pb-1"><x-logo /></a>
        <nav class="mt-1 flex-1 overflow-y-auto" aria-label="Navigasi utama">
            @foreach ($navGroups as $heading => $list)
                @if ($heading !== '')
                    <p class="px-3 pb-2 pt-5 text-[11px] font-semibold uppercase tracking-wider text-ink-muted">{{ $heading }}</p>
                @endif
                <div class="space-y-1">
                    @foreach ($list as $i)
                        <a href="{{ $i['url'] }}" @class([
                            'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition',
                            'bg-primary-tint font-semibold text-primary-dark' => $i['active'],
                            'font-medium text-ink hover:bg-neutral-tint' => ! $i['active'],
                        ]) @if ($i['active']) aria-current="page" @endif>
                            {{ $icon($i['icon'], '!text-[22px]', 22, $i['active'] ? '' : 'text-ink-muted') }}
                            <span class="flex-1 truncate">{{ $i['label'] }}</span>
                            @if ($i['soon'] ?? false)
                                <span class="size-1.5 shrink-0 rounded-full bg-warn" title="Segera"></span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-line pt-3">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-danger transition hover:bg-danger-tint">
                <span class="material-symbols-outlined !text-[22px]">logout</span>Logout
            </button>
        </form>
    </aside>

    <div class="lg:ml-64">
        {{-- Header desktop --}}
        <header class="sticky top-0 z-20 hidden h-16 items-center justify-between border-b border-line bg-white/85 px-8 backdrop-blur lg:flex">
            <div class="min-w-0">
                <p class="text-xs font-medium text-ink-muted">{{ $roleLabel }}</p>
                <p class="truncate text-base font-semibold leading-tight">{{ $title }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('placeholder', 'notifikasi') }}" class="relative grid size-10 place-items-center rounded-full text-ink-muted transition hover:bg-neutral-tint hover:text-ink" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                </a>
                <details class="relative" data-menu>
                    <summary class="flex cursor-pointer list-none items-center gap-3 rounded-full py-1 pl-1 pr-3 transition hover:bg-neutral-tint [&::-webkit-details-marker]:hidden">
                        <span class="grid size-9 place-items-center rounded-full bg-navy text-sm font-bold text-white">{{ $initial }}</span>
                        <span class="hidden text-left xl:block">
                            <span class="block max-w-40 truncate text-sm font-semibold leading-tight">{{ $user->name }}</span>
                            <span class="block text-xs text-ink-muted">{{ $roleLabel }}</span>
                        </span>
                        <span class="material-symbols-outlined !text-[20px] text-ink-muted">expand_more</span>
                    </summary>
                    <div class="absolute right-0 mt-2 w-60 rounded-card border border-line bg-white p-2 shadow-sheet">
                        <div class="px-3 py-2">
                            <p class="truncate text-sm font-semibold">{{ $user->name }}</p>
                            <p class="truncate text-xs text-ink-muted">{{ $user->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium hover:bg-neutral-tint">
                            <span class="material-symbols-outlined !text-[20px] text-ink-muted">person</span>Profil Saya
                        </a>
                    </div>
                </details>
            </div>
        </header>

        {{-- Topbar mobile --}}
        <header class="sticky top-0 z-20 flex items-center justify-between border-b border-line bg-white/90 px-5 py-3 backdrop-blur lg:hidden">
            <x-logo />
            <div class="flex items-center gap-1">
                <a href="{{ route('placeholder', 'notifikasi') }}" class="grid size-10 place-items-center rounded-full text-ink-muted" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="grid size-9 place-items-center rounded-full bg-navy text-sm font-bold text-white" aria-label="Profil">{{ $initial }}</a>
            </div>
        </header>

        <main class="px-5 pb-28 pt-6 lg:px-8 lg:pb-10">
            <div class="mx-auto max-w-6xl">
                <x-flash />
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- Bottom nav mobile --}}
    <nav class="fixed inset-x-0 bottom-0 z-30 flex items-stretch justify-around border-t border-line bg-white px-2 pb-[env(safe-area-inset-bottom)] shadow-sheet lg:hidden" aria-label="Navigasi bawah">
        @foreach ($bottom as $i)
            <a href="{{ $i['url'] }}" @class([
                'flex min-h-14 flex-1 flex-col items-center justify-center gap-0.5 text-[11px] font-medium',
                'text-primary-dark' => $i['active'],
                'text-slate-400' => ! $i['active'],
            ])>
                {{ $icon($i['icon'], '!text-[24px]', 24) }}
                {{ \Illuminate\Support\Str::limit($i['label'], 11, '') }}
            </a>
        @endforeach
        <button type="button" data-sheet-toggle class="flex min-h-14 flex-1 flex-col items-center justify-center gap-0.5 text-[11px] font-medium text-slate-400">
            <span class="material-symbols-outlined !text-[24px]">menu</span>Lainnya
        </button>
    </nav>

    {{-- Sheet menu lengkap (mobile) --}}
    <div id="more-sheet" class="fixed inset-0 z-40 hidden lg:hidden">
        <div data-sheet-toggle class="absolute inset-0 bg-navy/40"></div>
        <div class="absolute inset-x-0 bottom-0 max-h-[80vh] overflow-y-auto rounded-t-3xl bg-white p-5 shadow-sheet">
            <div class="mx-auto mb-4 h-1.5 w-12 rounded-full bg-line"></div>
            <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-ink-muted">{{ $roleLabel }}</p>
            <div class="space-y-1">
                @foreach ($items as $i)
                    <a href="{{ $i['url'] }}" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium {{ $i['active'] ? 'bg-primary-tint text-primary-dark' : 'text-ink' }}">
                        {{ $icon($i['icon'], '', 24) }}
                        <span class="flex-1">{{ $i['label'] }}</span>
                        @if ($i['soon'] ?? false)<span class="rounded-full bg-neutral-tint px-2 py-0.5 text-[10px] font-semibold text-ink-muted">Segera</span>@endif
                    </a>
                @endforeach
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-4 border-t border-line pt-4">
                @csrf
                <x-button type="submit" variant="danger" class="w-full" icon="logout">Keluar</x-button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-sheet-toggle]').forEach(function (el) {
            el.addEventListener('click', function () {
                document.getElementById('more-sheet').classList.toggle('hidden');
            });
        });
        document.addEventListener('click', function (e) {
            document.querySelectorAll('details[data-menu][open]').forEach(function (d) {
                if (!d.contains(e.target)) d.removeAttribute('open');
            });
        });
    </script>
</body>
</html>