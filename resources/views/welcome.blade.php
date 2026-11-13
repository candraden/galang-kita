<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galang Kita · Kelola Dana Kelompok dengan Transparan</title>
    <meta name="description" content="Galang Kita membantu komunitas mengelola iuran, kas, dan penggalangan dana: kewajiban jelas, bukti transfer rapi, verifikasi transparan.">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preload" as="image" href="{{ asset('images/hero-galang.webp') }}" type="image/webp">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ---------- Animasi masuk (scroll reveal) ---------- */
        .rv {
            opacity: 0;
            translate: 0 28px;
            transition:
                opacity .7s cubic-bezier(.2, .7, .2, 1) var(--d, 0ms),
                translate .7s cubic-bezier(.2, .7, .2, 1) var(--d, 0ms),
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }
        .rv.in { opacity: 1; translate: none; }

        /* Efek angkat saat di-hover (khusus kartu) */
        .lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 32px -8px rgba(15, 27, 51, .18), 0 6px 12px -4px rgba(16, 185, 129, .12);
            border-color: #6ee7b7;
        }

        /* Ikon di dalam kartu ikut bergerak halus saat kartu di-hover */
        .lift .ico { transition: transform .35s cubic-bezier(.2, .7, .2, 1); }
        .lift:hover .ico { transform: scale(1.12) rotate(-4deg); }

        /* ---------- Animasi ilustrasi hero ---------- */
        @keyframes floaty {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-12px); }
        }
        .float-slow { animation: floaty 6s ease-in-out infinite; }

        /* Pudarkan tepi ilustrasi agar menyatu dengan latar */
        .hero-art {
            -webkit-mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, #000 62%, transparent 100%);
            mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, #000 62%, transparent 100%);
        }

        @media (prefers-reduced-motion: reduce) {
            .rv { opacity: 1; translate: none; transition: none; }
            .lift:hover, .lift:hover .ico { transform: none; }
            .float-slow { animation: none; }
        }
    </style>
    <noscript><style>.rv { opacity: 1; translate: none; }</style></noscript>
</head>
<body class="bg-app font-sans text-ink antialiased">

    {{-- Navbar --}}
    <header class="sticky top-0 z-30 border-b border-line bg-white/85 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3">
            <a href="{{ route('home') }}"><x-logo /></a>
            <nav class="hidden items-center gap-8 text-sm font-medium text-ink-muted md:flex" aria-label="Navigasi halaman">
                <a href="#masalah" class="transition hover:text-ink">Masalah</a>
                <a href="#cara-kerja" class="transition hover:text-ink">Cara Kerja</a>
                <a href="#fitur" class="transition hover:text-ink">Fitur</a>
                <a href="#untuk-siapa" class="transition hover:text-ink">Untuk Siapa</a>
            </nav>
            <div class="flex items-center gap-2">
                @auth
                    <x-button :href="route('dashboard')" size="sm">Buka Dashboard</x-button>
                @else
                    <x-button :href="route('login')" variant="ghost" size="sm">Masuk</x-button>
                    <x-button :href="route('register')" size="sm">Daftar</x-button>
                @endauth
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-[linear-gradient(180deg,#ecfdf5_0%,#f6fdf9_55%,#ffffff_100%)]">
        {{-- Dekorasi latar --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0">
            <div class="absolute -left-40 top-1/3 size-[26rem] rounded-full bg-primary/10 blur-3xl"></div>
            <div class="absolute -right-32 -top-10 size-[30rem] rounded-full bg-primary-tint/80 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-8 px-5 py-12 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.12fr)] lg:gap-6 lg:py-16">

            {{-- Teks --}}
            <div class="lg:pr-6">
                <span class="rv inline-flex items-center gap-2 rounded-full bg-primary-tint px-3 py-1 text-xs font-semibold text-primary-dark" style="--d:0ms">
                    <span class="material-symbols-outlined !text-[16px]">verified_user</span>Transparan · Rapi · Mudah
                </span>
                <h1 class="rv mt-5 text-4xl font-bold leading-[1.1] tracking-tight text-navy sm:text-5xl lg:text-[64px]" style="--d:100ms">
                    Bersama Mengelola, <span class="text-primary-dark">Bersama Mencapai Tujuan.</span>
                </h1>
                <p class="rv mt-6 max-w-xl text-base leading-7 text-ink-muted lg:text-lg lg:leading-8" style="--d:200ms">
                    Galang Kita membantu komunitas, panitia, dan kelompok mengelola iuran, kas, serta penggalangan dana
                    dalam satu tempat. Kewajiban jelas, bukti transfer tersimpan rapi, dan status pembayaran bisa dipantau semua pihak.
                </p>
                <div class="rv mt-8 flex flex-wrap gap-3" style="--d:300ms">
                    @auth
                        <x-button :href="route('dashboard')" size="lg" icon="dashboard">Buka Dashboard</x-button>
                    @else
                        <x-button :href="route('register')" size="lg" icon="rocket_launch">Mulai Sekarang</x-button>
                        <x-button :href="route('login')" variant="outline" size="lg">Saya Sudah Punya Akun</x-button>
                    @endauth
                </div>
                <p class="rv mt-4 max-w-lg text-xs leading-5 text-ink-muted" style="--d:400ms">
                    Pembayaran tetap lewat transfer manual. Galang Kita tidak menyimpan atau memegang dana kamu.
                </p>
            </div>

            {{-- Ilustrasi + kartu --}}
            <div class="relative">
                <img src="{{ asset('images/hero-galang.webp') }}" width="1280" height="853"
                     alt="Tiga orang menabung bersama ke celengan ayam besar"
                     fetchpriority="high" style="--d:150ms"
                     class="rv hero-art float-slow mx-auto w-full max-w-[640px] mix-blend-multiply select-none">

                <div class="relative -mt-2 grid items-stretch gap-4 sm:grid-cols-[1.05fr_1fr]">
                    <x-hero-card class="rv lift h-full" style="--d:350ms"
                                 label="Total Dana Terverifikasi" value="Rp 48.750.000"
                                 note="82% dari target: Rp 59.500.000">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1.5 text-xs font-medium"><span class="material-symbols-outlined !text-[16px]">group</span>42 anggota</span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1.5 text-xs font-medium"><span class="material-symbols-outlined !text-[16px]">savings</span>2 program aktif</span>
                    </x-hero-card>

                    <div class="flex flex-col gap-3">
                        <x-card class="rv lift flex flex-1 items-center gap-3" style="--d:450ms">
                            <span class="ico grid size-11 shrink-0 place-items-center rounded-full bg-primary-tint font-bold text-primary-dark">R</span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold">Rian Pratama</p>
                                <p class="truncate text-xs text-ink-muted">Iuran Kas Bulanan</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-primary-dark">+Rp 150.000</p>
                                <x-badge-status status="pending" class="mt-1" />
                            </div>
                        </x-card>
                        <x-card class="rv lift flex flex-1 items-center gap-3" style="--d:550ms">
                            <span class="ico grid size-11 shrink-0 place-items-center rounded-full bg-blue-100 font-bold text-blue-700">S</span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold">Siti Aminah</p>
                                <p class="truncate text-xs text-ink-muted">Dana Siaga</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-primary-dark">+Rp 500.000</p>
                                <x-badge-status status="paid" class="mt-1" />
                            </div>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Masalah --}}
    <section id="masalah" class="scroll-mt-16 bg-white py-16">
        <div class="mx-auto max-w-6xl px-5">
            <h2 class="rv text-center text-3xl font-bold tracking-tight text-navy">Masalah yang sering terjadi</h2>
            <p class="rv mx-auto mt-3 max-w-2xl text-center text-ink-muted" style="--d:80ms">Mengelola uang bersama lewat chat dan catatan manual membuat hal sederhana jadi rumit.</p>
            <div class="mt-10 grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['forum', 'Pencatatan tercecer', 'Bukti transfer tenggelam di grup chat, catatan kas ada di banyak tempat.'],
                    ['help', 'Status tidak jelas', 'Siapa yang sudah bayar, siapa yang belum, dan berapa kurangnya sulit dipastikan.'],
                    ['visibility_off', 'Laporan kurang transparan', 'Anggota ragu karena tidak bisa melihat rekap dana secara terbuka.'],
                ] as $i => [$icon, $title, $text])
                    <x-card class="rv lift !p-6" style="--d:{{ $i * 120 }}ms">
                        <span class="ico grid size-12 place-items-center rounded-full bg-danger-tint text-danger"><span class="material-symbols-outlined">{{ $icon }}</span></span>
                        <h3 class="mt-4 text-lg font-semibold">{{ $title }}</h3>
                        <p class="mt-1 text-sm leading-6 text-ink-muted">{{ $text }}</p>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Cara kerja --}}
    <section id="cara-kerja" class="scroll-mt-16 py-16">
        <div class="mx-auto max-w-6xl px-5">
            <h2 class="rv text-center text-3xl font-bold tracking-tight text-navy">Cara kerja</h2>
            <p class="rv mx-auto mt-3 max-w-2xl text-center text-ink-muted" style="--d:80ms">Empat langkah dari membuat grup sampai dana terverifikasi.</p>
            <ol class="mt-10 grid gap-4 md:grid-cols-4">
                @foreach ([
                    ['Buat grup', 'Penggalang dana membuat grup dan program pengumpulan dana.'],
                    ['Undang anggota', 'Bagikan tautan undangan agar anggota bergabung sendiri.'],
                    ['Bayar & kirim bukti', 'Anggota transfer manual lalu unggah bukti pembayaran.'],
                    ['Verifikasi', 'Penggalang dana memeriksa bukti, status otomatis diperbarui.'],
                ] as $i => [$title, $text])
                    <li>
                        <x-card class="rv lift h-full !p-6" style="--d:{{ $i * 120 }}ms">
                            <span class="ico grid size-10 place-items-center rounded-full bg-navy text-sm font-bold text-white">{{ $i + 1 }}</span>
                            <h3 class="mt-4 font-semibold">{{ $title }}</h3>
                            <p class="mt-1 text-sm leading-6 text-ink-muted">{{ $text }}</p>
                        </x-card>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Fitur --}}
    <section id="fitur" class="scroll-mt-16 bg-white py-16">
        <div class="mx-auto max-w-6xl px-5">
            <h2 class="rv text-center text-3xl font-bold tracking-tight text-navy">Fitur utama</h2>
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['groups', 'Manajemen grup', 'Kelola banyak grup dan daftar anggota dari satu akun.'],
                    ['link', 'Tautan undangan', 'Anggota bergabung lewat tautan, tanpa input data manual.'],
                    ['savings', 'Program dana', 'Iuran tetap, kas rutin, hingga donasi sukarela dalam satu grup.'],
                    ['receipt_long', 'Kewajiban jelas', 'Setiap anggota melihat tagihan, nominal, dan tenggatnya.'],
                    ['fact_check', 'Verifikasi pembayaran', 'Periksa bukti transfer, setujui atau tolak dengan catatan.'],
                    ['bar_chart', 'Riwayat & laporan', 'Rekap pembayaran yang rapi dan mudah dipertanggungjawabkan.'],
                ] as $i => [$icon, $title, $text])
                    <x-card class="rv lift flex gap-4 !p-5" style="--d:{{ ($i % 3) * 100 + intdiv($i, 3) * 120 }}ms">
                        <span class="ico grid size-12 shrink-0 place-items-center rounded-full bg-primary-tint text-primary-dark"><span class="material-symbols-outlined">{{ $icon }}</span></span>
                        <div><h3 class="font-semibold">{{ $title }}</h3><p class="mt-1 text-sm leading-6 text-ink-muted">{{ $text }}</p></div>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Untuk siapa --}}
    <section id="untuk-siapa" class="scroll-mt-16 py-16">
        <div class="mx-auto max-w-6xl px-5">
            <h2 class="rv text-center text-3xl font-bold tracking-tight text-navy">Untuk siapa?</h2>
            <div class="mt-10 grid gap-4 md:grid-cols-2">
                <x-card class="rv lift !p-7" style="--d:0ms">
                    <span class="ico grid size-12 place-items-center rounded-full bg-navy text-white"><span class="material-symbols-outlined">manage_accounts</span></span>
                    <h3 class="mt-4 text-xl font-semibold">Penggalang Dana</h3>
                    <p class="mt-1 text-sm text-ink-muted">Ketua komunitas, bendahara, atau panitia kegiatan.</p>
                    <ul class="mt-4 space-y-2 text-sm">
                        @foreach (['Buat grup dan program dana', 'Undang dan kelola anggota', 'Verifikasi pembayaran masuk', 'Pantau rekap dan laporan'] as $p)
                            <li class="flex gap-2"><span class="material-symbols-outlined !text-[20px] text-primary-dark">check_circle</span>{{ $p }}</li>
                        @endforeach
                    </ul>
                </x-card>
                <x-card class="rv lift !p-7" style="--d:150ms">
                    <span class="ico grid size-12 place-items-center rounded-full bg-primary text-white"><span class="material-symbols-outlined">person</span></span>
                    <h3 class="mt-4 text-xl font-semibold">Anggota</h3>
                    <p class="mt-1 text-sm text-ink-muted">Warga, mahasiswa, atau peserta yang membayar iuran.</p>
                    <ul class="mt-4 space-y-2 text-sm">
                        @foreach (['Gabung lewat tautan undangan', 'Lihat kewajiban dan tenggat', 'Kirim bukti pembayaran', 'Pantau status dan riwayat'] as $p)
                            <li class="flex gap-2"><span class="material-symbols-outlined !text-[20px] text-primary-dark">check_circle</span>{{ $p }}</li>
                        @endforeach
                    </ul>
                </x-card>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="px-5 pb-16">
        <x-hero-card class="rv lift mx-auto max-w-6xl !p-10 text-center sm:!p-14" label="Siap mulai?" value="Kelola dana kelompok tanpa ribet">
            <div class="mx-auto flex flex-wrap justify-center gap-3">
                @auth
                    <x-button :href="route('dashboard')" size="lg">Buka Dashboard</x-button>
                @else
                    <x-button :href="route('register')" size="lg" icon="rocket_launch">Daftar Gratis</x-button>
                    <x-button :href="route('login')" variant="on-dark" size="lg">Masuk</x-button>
                @endauth
            </div>
        </x-hero-card>
    </section>

    <footer class="border-t border-line bg-white py-8">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-5 text-sm text-ink-muted sm:flex-row">
            <x-logo />
            <p>© {{ date('Y') }} Galang Kita. Platform ini hanya mencatat pembayaran dan tidak memegang dana pengguna.</p>
        </div>
    </footer>

    <script>
        (function () {
            var els = [].slice.call(document.querySelectorAll('.rv'));
            if (!('IntersectionObserver' in window)) {
                els.forEach(function (el) { el.classList.add('in'); });
                return;
            }
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
            els.forEach(function (el) { io.observe(el); });
        })();
    </script>
</body>
</html>
