<?php

/*
 * Menu navigasi per peran. 'soon' => true menampilkan penanda "Segera"
 * dan membuka halaman placeholder. 'match' dipakai agar menu tetap aktif
 * di halaman turunan (detail, edit, dll.). 'group' = judul kelompok di sidebar
 * (item sekelompok harus berurutan).
 */
$soon = fn (string $label, string $icon, string $page, ?string $group = null) => [
    'label' => $label, 'icon' => $icon, 'group' => $group,
    'route' => 'placeholder', 'params' => ['page' => $page], 'soon' => true,
];

return [
    'roles' => [
        'super_admin' => 'Super Admin',
        'fundraiser'  => 'Penggalang Dana',
        'member'      => 'Anggota',
    ],

    'group_categories' => [
        'Komunitas',
        'Kepanitiaan',
        'Organisasi Kampus',
        'Keluarga',
        'Arisan',
        'Lainnya',
    ],

    'menus' => [
        'super_admin' => [
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'admin.dashboard', 'group' => 'Menu Utama'],
            ['label' => 'Pengguna',  'icon' => 'group',     'route' => 'admin.users',     'group' => 'Menu Utama'],
            ['label' => 'Grup',      'icon' => 'groups',    'route' => 'admin.groups',    'group' => 'Menu Utama'],
            $soon('Aktivitas Platform', 'history', 'aktivitas-platform', 'Pemantauan'),
            $soon('Laporan & Pengaduan', 'flag', 'laporan-pengaduan', 'Pemantauan'),
            $soon('Pengaturan Sistem', 'settings', 'pengaturan-sistem', 'Preferensi'),
        ],
        'fundraiser' => [
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'fundraiser.dashboard', 'group' => 'Menu Utama'],
            ['label' => 'Grup Saya', 'icon' => 'groups', 'route' => 'fundraiser.groups.index', 'match' => 'penggalang/grup*', 'group' => 'Menu Utama'],
            ['label' => 'Anggota', 'icon' => 'group', 'route' => 'fundraiser.members.index', 'match' => 'penggalang/anggota*', 'group' => 'Menu Utama'],
            $soon('Program Dana', 'ayam', 'program-dana', 'Pengelolaan Dana'),
            $soon('Kewajiban', 'receipt_long', 'kewajiban', 'Pengelolaan Dana'),
            $soon('Verifikasi Pembayaran', 'fact_check', 'verifikasi-pembayaran', 'Pengelolaan Dana'),
            $soon('Laporan', 'bar_chart', 'laporan', 'Pengelolaan Dana'),
            ['label' => 'Pengaturan', 'icon' => 'settings', 'route' => 'profile.edit', 'group' => 'Preferensi'],
        ],
        'member' => [
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'member.dashboard', 'group' => 'Menu Utama'],
            $soon('Grup Saya', 'groups', 'grup-saya', 'Menu Utama'),
            $soon('Program Dana', 'ayam', 'program-dana', 'Pembayaran'),
            $soon('Kewajiban Saya', 'receipt_long', 'kewajiban-saya', 'Pembayaran'),
            $soon('Kirim Bukti Pembayaran', 'upload_file', 'kirim-bukti', 'Pembayaran'),
            $soon('Riwayat Pembayaran', 'history', 'riwayat-pembayaran', 'Pembayaran'),
            ['label' => 'Pengaturan', 'icon' => 'settings', 'route' => 'profile.edit', 'group' => 'Preferensi'],
        ],
    ],
];