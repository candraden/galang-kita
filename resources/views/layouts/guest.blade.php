<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Galang Kita') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">

    <style>
        @media (prefers-reduced-motion: no-preference) {
            /* Satu momen: kartu masuk saat halaman dibuka */
            @keyframes auth-card-in {
                from { opacity: 0; transform: translateY(16px) scale(.985); }
                to   { opacity: 1; transform: none; }
            }
            .auth-card { animation: auth-card-in .6s cubic-bezier(.2,.7,.2,1) both; }

            /* Fallback saat GIF belum ada: motif konsentris berdenyut pelan */
            @keyframes auth-ring {
                0%, 100% { transform: scale(1); opacity: .10; }
                50%      { transform: scale(1.06); opacity: .16; }
            }
            .auth-rings { animation: auth-ring 6s ease-in-out infinite; }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-ink antialiased">
    <div class="flex min-h-screen items-center justify-center bg-app bg-[radial-gradient(60rem_40rem_at_10%_-10%,#D1FAE5_0%,transparent_60%),radial-gradient(50rem_36rem_at_100%_110%,#D4DFFF_0%,transparent_55%)] p-4 sm:p-6">

        <div class="auth-card grid w-full max-w-5xl gap-2 rounded-hero bg-white p-2.5 shadow-hero lg:grid-cols-2 lg:gap-6">

            {{-- Panel visual: taruh GIF di public/images/login-hero.gif --}}
            <aside class="relative min-h-[180px] overflow-hidden rounded-card bg-navy lg:min-h-[560px]">
                <svg class="auth-rings pointer-events-none absolute -right-24 -top-24 h-[380px] w-[380px] text-white opacity-10"
                     viewBox="0 0 420 420" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <circle cx="210" cy="210" r="60"/><circle cx="210" cy="210" r="100"/>
                    <circle cx="210" cy="210" r="140"/><circle cx="210" cy="210" r="180"/>
                    <circle cx="210" cy="210" r="208"/>
                </svg>

                <img src="{{ asset('images/login-hero.gif') }}" alt=""
                     class="absolute inset-0 h-full w-full object-cover"
                     onerror="this.remove()">

                <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-navy/80 to-transparent"></div>

                <h1 class="absolute bottom-5 left-5 right-5 text-2xl font-extrabold uppercase leading-[1.05] tracking-tight text-white sm:text-3xl lg:bottom-8 lg:left-8 lg:text-[44px]">
                    Bersama<br>Mengelola.<br>Bersama<br class="hidden lg:inline"> Mencapai.
                </h1>
            </aside>

            {{-- Form --}}
            <main class="flex flex-col justify-center px-4 py-8 sm:px-10 lg:px-6">
                <a href="/" class="mx-auto mb-6 inline-flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary">
                        <span class="material-symbols-outlined text-[20px] text-white" aria-hidden="true">groups</span>
                    </span>
                    <span class="text-base font-bold tracking-tight">Galang Kita</span>
                </a>

                <div class="mx-auto w-full max-w-sm">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>