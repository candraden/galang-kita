<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ config('app.name', 'Galang Kita') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh overflow-x-hidden bg-[linear-gradient(135deg,#ecfdf5,#ffffff_50%,#f4f6f8)] font-sans text-ink antialiased">

    {{-- Dekorasi latar --}}
    <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        {{-- blob kiri atas --}}
        <div class="absolute -left-24 -top-24 size-72 rounded-full bg-primary/15 blur-xl"></div>
        {{-- blob kiri bawah (hijau gradasi) --}}
        <div class="absolute -bottom-28 -left-20 hidden size-80 rounded-full bg-gradient-to-tr from-teal-600 to-primary opacity-80 sm:block"></div>
        <div class="absolute -bottom-20 -left-8 hidden size-56 rounded-full bg-primary/50 sm:block"></div>
        {{-- blob kanan bawah (mint) --}}
        <div class="absolute -bottom-20 -right-16 size-72 rounded-full bg-primary/20 blur-xl"></div>
        {{-- lingkaran konsentris kiri atas & kanan atas --}}
        <svg class="absolute -left-20 -top-20 hidden size-80 text-primary opacity-10 sm:block" viewBox="0 0 200 200" fill="none" stroke="currentColor">
            <circle cx="100" cy="100" r="30"/><circle cx="100" cy="100" r="52"/><circle cx="100" cy="100" r="74"/><circle cx="100" cy="100" r="96"/>
        </svg>
        <svg class="absolute -right-16 -top-16 hidden size-80 text-primary opacity-10 sm:block" viewBox="0 0 200 200" fill="none" stroke="currentColor">
            <circle cx="100" cy="100" r="30"/><circle cx="100" cy="100" r="52"/><circle cx="100" cy="100" r="74"/><circle cx="100" cy="100" r="96"/>
        </svg>
    </div>

    <main class="mx-auto flex min-h-dvh w-full max-w-5xl items-center px-4 pb-[max(1.5rem,env(safe-area-inset-bottom))] pt-[max(1.5rem,env(safe-area-inset-top))] sm:px-6">
        <div class="grid w-full overflow-hidden rounded-[28px] bg-white p-2.5 shadow-hero lg:grid-cols-2 lg:gap-2">

            {{-- Konten: pertama di mobile, kanan di desktop --}}
            <section class="order-1 flex flex-col justify-center px-2 py-6 sm:px-8 lg:order-2 lg:py-10">
                <a href="{{ route('home') }}" class="mx-auto mb-6"><x-logo /></a>
                <div class="mx-auto w-full max-w-sm lg:max-w-md">
                    {{ $slot }}
                </div>
            </section>

            {{-- Panel Navy: banner di bawah (mobile), panel kiri (desktop) --}}
            <aside class="relative order-2 mt-2 overflow-hidden rounded-3xl bg-navy p-6 text-white lg:order-1 lg:mt-0 lg:flex lg:flex-col lg:justify-center lg:p-12">
                <svg aria-hidden="true" class="pointer-events-none absolute -right-12 -top-12 size-56 text-white opacity-10 lg:-right-20 lg:-top-20 lg:size-80" viewBox="0 0 200 200" fill="none" stroke="currentColor">
                    <circle cx="100" cy="100" r="30"/><circle cx="100" cy="100" r="52"/><circle cx="100" cy="100" r="74"/><circle cx="100" cy="100" r="96"/>
                </svg>
                <svg aria-hidden="true" class="pointer-events-none absolute -bottom-16 -left-16 hidden size-64 text-white opacity-5 lg:block" viewBox="0 0 200 200" fill="none" stroke="currentColor">
                    <circle cx="100" cy="100" r="30"/><circle cx="100" cy="100" r="52"/><circle cx="100" cy="100" r="74"/><circle cx="100" cy="100" r="96"/>
                </svg>
                <div class="relative">
                    <h2 class="text-3xl font-extrabold uppercase leading-[1.1] tracking-tight lg:text-5xl">
                        <span class="block">Bersama</span>
                        <span class="block">Mengelola.</span>
                        <span class="block">Bersama</span>
                        <span class="block">Mencapai.</span>
                    </h2>
                    <p class="mt-4 hidden max-w-xs text-base leading-7 text-white/80 lg:block">
                        Bergabung dan jadilah bagian dari komunitas Galang Kita.
                    </p>
                    <span class="mt-6 hidden h-1 w-20 overflow-hidden rounded-full bg-white/15 lg:block">
                        <span class="block h-full w-1/2 rounded-full bg-primary"></span>
                    </span>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>