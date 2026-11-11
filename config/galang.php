<?php

/*
 * Menu navigasi per peran. 'soon' => true menampilkan badge "Segera"
 * dan membuka halaman placeholder. Ganti 'route' saat fitur sudah jadi.
 */
$soon = fn (string $label, string $icon, string $page) => [
    'label' => $label, 'icon' => $icon,
    'route' => 'placeholder', 'params' => ['page' => $page], 'soon' => true,
];

return [
    'roles' => [
        'super_admin' => 'Super Admin',
        'fundraiser'  => 'Penggalang Dana',
        'member'      => 'Anggota',
    ],

    'menus' => [
        'super_admin' => [
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'admin.dashboard'],
            ['label' => 'Pengguna',  'icon' => 'group',     'route' => 'admin.users'],
            ['label' => 'Grup',      'icon' => 'groups',    'route' => 'admin.groups'],
            $soon('Aktivitas Platform', 'history', 'aktivitas-platform'),
            $soon('Laporan & Pengaduan', 'flag', 'laporan-pengaduan'),
            $soon('Pengaturan Sistem', 'settings', 'pengaturan-sistem'),
        ],
        'fundraiser' => [
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'fundraiser.dashboard'],
            $soon('Grup Saya', 'groups', 'grup-saya'), // ganti ke route CRUD Grup di Hari 2
            $soon('Anggota', 'group', 'anggota'),
            $soon('Program Dana', 'savings', 'program-dana'),
            $soon('Kewajiban', 'receipt_long', 'kewajiban'),
            $soon('Verifikasi Pembayaran', 'fact_check', 'verifikasi-pembayaran'),
            $soon('Laporan', 'bar_chart', 'laporan'),
            $soon('Pengaturan', 'settings', 'pengaturan'),
        ],
        'member' => [
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'member.dashboard'],
            $soon('Grup Saya', 'groups', 'grup-saya'),
            $soon('Program Dana', 'savings', 'program-dana'),
            $soon('Kewajiban Saya', 'receipt_long', 'kewajiban-saya'),
            $soon('Kirim Bukti Pembayaran', 'upload_file', 'kirim-bukti'),
            $soon('Riwayat Pembayaran', 'history', 'riwayat-pembayaran'),
            $soon('Pengaturan', 'settings', 'pengaturan'),
        ],
    ],
];
