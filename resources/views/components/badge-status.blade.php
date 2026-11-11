@props(['status' => 'unpaid', 'label' => null])
@php
    $map = [
        'paid'      => ['Sudah Lunas', 'check_circle', 'bg-primary-tint text-primary-dark'],
        'pending'   => ['Menunggu Verifikasi', 'schedule', 'bg-warn-tint text-warn'],
        'unpaid'    => ['Belum Dibayar', 'error', 'bg-neutral-tint text-ink-muted'],
        'rejected'  => ['Ditolak', 'cancel', 'bg-danger-tint text-danger'],
        // status akun / grup
        'active'    => ['Aktif', 'check_circle', 'bg-primary-tint text-primary-dark'],
        'inactive'  => ['Nonaktif', 'remove_circle', 'bg-neutral-tint text-ink-muted'],
        'suspended' => ['Ditangguhkan', 'block', 'bg-danger-tint text-danger'],
    ];
    [$text, $icon, $class] = $map[$status] ?? $map['unpaid'];
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold {$class}"]) }}>
    <span class="material-symbols-outlined !text-[14px]">{{ $icon }}</span>{{ $label ?? $text }}
</span>
