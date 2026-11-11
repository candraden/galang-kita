@props(['title' => 'Dashboard'])
@php
    $user  = auth()->user();
    $role  = $user->currentRole();
    $items = collect(config("galang.menus.$role", []))->map(function ($i) {
        $url = route($i['route'], $i['params'] ?? []);
        return $i + [
    'url' => $url,
    'active' => isset($i['match']) ? request()->is($i['match']) : url()->current() === $url,
    ];
    });
    $roleLabel = config("galang.roles.$role", '');
    $initial   = strtoupper(mb_substr($user->name, 0, 1));
    $bottom    = $items->take(4);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · Galang Kita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-app font-sans text-ink antialiased">

    {{-- Sidebar desktop --}}
    <aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-line bg-white p-4 lg:flex">
        <a href="{{ route('dashboard') }}" class="px-2 py-3"><x-logo /></a>
        <nav class="mt-4 flex-1 space-y-1 overflow-y-auto" aria-label="Navigasi utama">
            @foreach ($items as $i)
                <a href="{{ $i['url'] }}" @class([
                    'flex items-center gap-3 rounded-full px-4 py-2.5 text-sm font-medium transition',
                    'bg-primary-tint text-primary-dark' => $i['active'],
                    'text-ink-muted hover:bg-neutral-tint hover:text-ink' => ! $i['active'],
                ]) @if ($i['active']) aria-current="page" @endif>
                    <span class="material-symbols-outlined !text-[22px]">{{ $i['icon'] }}</span>
                    <span class="flex-1">{{ $i['label'] }}</span>
                    @if ($i['soon'] ?? false)
                        <span class="rounded-full bg-neutral-tint px-2 py-0.5 text-[10px] font-semibold text-ink-muted">Segera</span>
                    @endif
                </a>
            @endforeach
        </nav>
        <div class="border-t border-line pt-4">
            <div class="flex items-center gap-3 px-2">
                <span class="grid size-10 place-items-center rounded-full bg-navy text-sm font-bold text-white">{{ $initial }}</span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold">{{ $user->name }}</p>
                    <p class="text-xs text-ink-muted">{{ $roleLabel }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <x-button type="submit" variant="ghost" size="sm" icon="logout" class="w-full">Keluar</x-button>
            </form>
        </div>
    </aside>

    {{-- Topbar mobile --}}
    <header class="sticky top-0 z-20 flex items-center justify-between border-b border-line bg-white/90 px-5 py-3 backdrop-blur lg:hidden">
        <x-logo />
        <span class="grid size-9 place-items-center rounded-full bg-navy text-sm font-bold text-white">{{ $initial }}</span>
    </header>

    <main class="px-5 pb-28 pt-6 lg:ml-64 lg:px-8 lg:pb-10">
        <div class="mx-auto max-w-5xl">
            <x-flash />
            {{ $slot }}
        </div>
    </main>

    {{-- Bottom nav mobile --}}
    <nav class="fixed inset-x-0 bottom-0 z-30 flex items-stretch justify-around border-t border-line bg-white px-2 pb-[env(safe-area-inset-bottom)] shadow-sheet lg:hidden" aria-label="Navigasi bawah">
        @foreach ($bottom as $i)
            <a href="{{ $i['url'] }}" @class([
                'flex min-h-14 flex-1 flex-col items-center justify-center gap-0.5 text-[11px] font-medium',
                'text-primary-dark' => $i['active'],
                'text-slate-400' => ! $i['active'],
            ])>
                <span class="material-symbols-outlined !text-[24px]">{{ $i['icon'] }}</span>
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
                        <span class="material-symbols-outlined">{{ $i['icon'] }}</span>
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
    </script>
</body>
</html>
