# Design System: Galang Kita

Panduan desain untuk **Galang Kita** (platform pengelolaan dana kelompok). Dasar: PRD v1.1 dan hasil generate Stitch ("Galang Kita Modern Fintech").
Stack implementasi: Laravel Blade + Tailwind CSS, mobile-first, responsif.

---

## 1. Brand & Gaya

**Kepribadian:** transparan, aman, modern, inklusif. Membangun rasa percaya dan akuntabilitas tanpa terasa kaku seperti perbankan.

**Gaya visual:** Modern Fintech Minimalism.
- Latar abu-abu terang lembut, kartu putih lapang.
- *Hero card* Navy gelap dengan garis konsentris halus (opacity 8-12%) di sudut kanan atas.
- Emerald hanya untuk aksi utama dan status berhasil.
- Sudut membulat besar, tombol berbentuk pill.
- Angka/nominal selalu menjadi fokus tipografi.

**Tagline:** Bersama Mengelola, Bersama Mencapai Tujuan.
**Bahasa UI:** Indonesia.

---

## 2. Color Tokens

### Warna inti

| Token | Hex | Pemakaian |
|---|---|---|
| `primary` (Emerald) | `#10B981` | CTA utama, indikator sukses, progress bar |
| `primary-dark` | `#059669` | Hover/pressed, teks di atas tint hijau |
| `primary-tint` | `#D1FAE5` | Latar badge lunas, highlight dana masuk |
| `navy` | `#0F1B33` | Hero card, app bar kontekstual, tombol sekunder gelap |
| `bg` | `#F4F6F8` | Latar layar |
| `surface` | `#FFFFFF` | Kartu, input, bottom nav |
| `border` | `#E5E7EB` | Border kartu dan input |
| `text` | `#0F172A` | Heading dan nominal |
| `text-muted` | `#64748B` | Label dan meta |
| `warning` | `#F59E0B` | Menunggu verifikasi, tenggat |
| `danger` | `#EF4444` | Ditolak, error |

### Status pembayaran (sesuai PRD 6.7)

| Status | Teks/ikon | Latar | Ikon |
|---|---|---|---|
| Sudah Lunas | `#059669` | `#D1FAE5` | centang |
| Menunggu Verifikasi | `#D97706` | `#FEF3C7` | jam |
| Belum Dibayar | `#64748B` | `#F1F5F9` | titik / seru |
| Ditolak | `#DC2626` | `#FEE2E2` | silang |

> Status jangan hanya dibedakan lewat warna; selalu sertakan ikon dan label teks.

### Token Material (hasil Stitch)

Stitch menghasilkan palet gaya Material 3 yang dipakai di `tailwind.config` tiap layar. Nilai utama:

| Token | Hex |
|---|---|
| `primary` | `#006C49` |
| `primary-container` | `#10B981` |
| `on-primary-container` | `#00422B` |
| `secondary` | `#535E7A` |
| `secondary-container` | `#D4DFFF` |
| `tertiary` | `#855300` |
| `tertiary-container` | `#E29100` |
| `error` / `error-container` | `#BA1A1A` / `#FFDAD6` |
| `surface` / `background` | `#F8F9FF` |
| `surface-container-low` | `#EFF4FF` |
| `surface-container` | `#E5EEFF` |
| `surface-container-high` | `#DCE9FF` |
| `on-surface` | `#0B1C30` |
| `on-surface-variant` | `#3C4A42` |
| `outline` / `outline-variant` | `#6C7A71` / `#BBCABF` |

**Aturan pakai:** untuk kode produksi, pakai token inti di tabel pertama sebagai sumber kebenaran. Token Material hanya dipakai bila menyalin langsung dari `code.html` Stitch, dan satukan ke satu skema saat refactor agar tidak ada dua nilai hijau yang berbeda (`#006C49` vs `#10B981`).

---

## 3. Tipografi

Font: **Plus Jakarta Sans** (Google Fonts), bobot 400, 500, 600, 700.

| Level | Ukuran / Line height | Bobot | Letter spacing | Pemakaian |
|---|---|---|---|---|
| `display-lg` | 40 / 48 | 700 | -0.02em | Total dana, angka agregat |
| `display-md` | 32 / 40 | 700 | -0.02em | Nominal di hero card |
| `headline-lg` | 24 / 32 | 600 | -0.01em | Judul layar, nama grup |
| `headline-md` | 18 / 26 | 600 | -0.005em | Judul seksi |
| `headline-sm` | 16 / 24 | 600 | 0 | Nama anggota, judul item |
| `body-lg` | 16 / 24 | 400 | 0 | Isi teks |
| `body-md` | 14 / 20 | 400 | 0 | Deskripsi, instruksi |
| `label-lg` | 14 / 20 | 600 | 0 | Teks tombol |
| `label-md` | 12 / 16 | 500 | 0 | Label form, meta |
| `caption` | 11 / 14 | 500 | 0 | Tanggal, keterangan kecil |

Nominal uang: format `Rp 48.750.000` (titik sebagai pemisah ribuan), pakai `font-variant-numeric: tabular-nums` pada tabel dan daftar agar angka sejajar.

---

## 4. Spacing, Grid, dan Radius

### Spacing (grid 8px)

| Token | Nilai | Pemakaian |
|---|---|---|
| `space-xs` | 4px | Ikon dan label inline |
| `space-sm` | 8px | Antar elemen dalam komponen |
| `space-md` | 16px | Padding kartu, gutter |
| `space-lg` | 24px | Padding hero card, jarak antar seksi |
| `space-xl` | 32px | Pemisah modul besar |

Margin halaman: 20px (mobile), 32px (desktop).

### Grid dan breakpoint

| Viewport | Grid | Catatan |
|---|---|---|
| < 768px | 4 kolom, gutter 16px | Fokus utama (360-428px) |
| 768-1024px | 8 kolom | Alur transaksi maks. 640px |
| > 1024px | 12 kolom + sidebar navigasi | Dashboard split |

### Radius

| Elemen | Radius |
|---|---|
| Kartu dan container | 20-24px |
| Hero card | 24px |
| Tombol utama | pill (9999px) |
| Input | 16px |
| Badge dan chip | pill |
| Avatar | lingkaran penuh |

---

## 5. Elevasi

| Level | Pemakaian | Shadow |
|---|---|---|
| 0 | Latar, container pasif | tanpa shadow, border `#E5E7EB` |
| 1 | Kartu standar, list item | `0 1px 3px rgba(15,23,42,.04), 0 4px 12px rgba(15,23,42,.03)` |
| 2 | Hero card, CTA melayang | `0 8px 24px -4px rgba(15,27,51,.12), 0 4px 8px -2px rgba(16,185,129,.08)` |
| 3 | Bottom sheet, modal | `0 -8px 32px rgba(15,23,42,.12)` |

---

## 6. Komponen

### Tombol

| Varian | Spesifikasi |
|---|---|
| **Primary** | Bg Emerald, teks putih, tinggi 52px, pill, `label-lg`. Pressed: `#059669` + `scale(0.98)` |
| **Secondary (Navy)** | Bg `#0F1B33`, teks putih, pill |
| **Outline** | Transparan, border 1.5px Emerald, teks `#059669` |
| **Soft** | Bg `#D1FAE5`, teks `#059669` |
| **Danger soft** | Bg `#FEE2E2`, teks `#DC2626` (aksi Tolak) |
| **Text** | Transparan, teks `#64748B` atau Emerald ("Lihat semua") |

Target sentuh minimal 44px. Tombol aksi utama di form dibuat *sticky* di bawah layar.

### Hero Card (Navy)

- Bg `#0F1B33`, teks putih, radius 24px, padding 24px, elevasi 2.
- Isi: label kecil uppercase, nominal `display-md`, chip persentase target, baris aksi cepat (maks. 3 tombol).
- Motif konsentris di pojok kanan atas, opacity 8-12%.
- Dipakai di: Dashboard penggalang dana, Kewajiban Saya.

### Kartu standar

Bg putih, border 1px `#E5E7EB`, radius 20px, padding 16px, elevasi 1. Dipakai untuk stat card, program, kewajiban.

### Stat Card (dua kolom)

Ikon bulat 40px dengan tint, chip kecil di kanan atas (mis. "Segera"), label, nilai tebal, sub-nominal. Contoh: *Menunggu Verifikasi* (amber) dan *Belum Membayar* (biru).

### Progress Bar

Track `#E5EEFF`, fill Emerald, tinggi 8px, pill. Di atasnya nama program, di bawahnya `terkumpul / target` dan jumlah partisipan. Badge persentase di pojok kanan atas kartu.

### Badge Status

Padding 4px 12px, pill, teks 12px semibold, dengan ikon. Warna sesuai tabel status di bagian 2.

### Input

- Tinggi 50px, radius 16px, bg putih, border `1.5px #E5E7EB`.
- Fokus: border `1.5px #10B981`. Error: border merah + pesan di bawah.
- Label di atas input (`label-md`, `#64748B`).
- Input nominal punya prefix **Rp** tebal di kiri.

### Upload Bukti Transfer

Dropzone border putus-putus, ikon unggah, teks "Unggah bukti transfer", batas tipe dan ukuran file ditampilkan. Setelah dipilih: thumbnail preview + tombol ganti/hapus.

### List Item (aktivitas/riwayat)

Kiri: avatar atau ikon 44px. Tengah: judul `headline-sm` + meta `label-md`. Kanan: nominal (`+` Emerald untuk dana masuk) dengan badge di bawahnya. Divider sejajar teks (tidak memotong avatar).

### Tabs / Filter Chip

Chip pill: aktif Emerald solid (teks putih), tidak aktif `#EFF4FF` (teks gelap). Menampilkan jumlah, mis. `Menunggu (7)`.

### Bottom Navigation (mobile)

Fixed, bg putih, elevasi 3, 5 item:

| Posisi | Label | Ikon |
|---|---|---|
| 1 | Ringkasan | `dashboard` |
| 2 | Grup | `groups` |
| 3 (tengah) | Galang | `add` (FAB Emerald 56px, menonjol 12px) |
| 4 | Program | `fact_check` |
| 5 | Pengaturan | `settings` |

Aktif: Emerald. Tidak aktif: `#94A3B8`. Di desktop berubah menjadi sidebar.

### Ikon

Material Symbols Outlined (stroke tipis, rounded). Ukuran 20-24px.

---

## 7. Inventaris Layar (hasil Stitch)

| Layar | Peran | Isi utama |
|---|---|---|
| Design System Overview | Semua | Palet, tipografi, radius, shadow, logo |
| Component Library | Semua | Tombol, input, badge, kartu, tabs, modal, nav |
| Dashboard Penggalang Dana | Penggalang dana | Sapaan, hero Total Dana Terverifikasi (+% target), aksi cepat (Program, Undang, Periksa), 2 stat card, Program Aktif, Aktivitas Masuk |
| Kewajiban Saya | Anggota | Hero total kewajiban, filter status, kartu kewajiban + tombol "Bayar & Kirim Bukti" |
| Kirim Bukti Pembayaran | Anggota | Ringkasan kewajiban, rekening tujuan + salin, form transfer, upload bukti, tombol sticky |
| Verifikasi Pembayaran | Penggalang dana | Antrean transaksi (carousel), detail bukti, nomor referensi, catatan penolakan, Setujui / Tolak |

### Layar yang belum ada (perlu didesain berdasarkan PRD)

Landing page, login/registrasi, detail grup, daftar anggota, tautan undangan, buat/ubah program, permintaan keluar grup, laporan dan ekspor, notifikasi, profil, serta area Super Admin (pengguna, grup, aktivitas, laporan penyalahgunaan).

---

## 8. Pola Interaksi

- **Alur pembayaran anggota:** Kewajiban Saya → Kirim Bukti → status berubah ke *Menunggu Verifikasi* → notifikasi hasil.
- **Alur verifikasi:** pilih transaksi dari antrean → periksa bukti dan data → *Setujui & Verifikasi* atau *Tolak* (catatan penolakan wajib saat menolak).
- **Konfirmasi tindakan penting** (setujui, tolak, nonaktifkan tautan, keluar grup) memakai bottom sheet/modal.
- **Loading:** skeleton pada kartu dan list; tombol menampilkan spinner dan dinonaktifkan saat submit.
- **Empty state:** ilustrasi sederhana, satu kalimat penjelasan, satu CTA.
- **Pagination** untuk daftar panjang (PRD 7.1).

---

## 9. Aksesibilitas

- Kontras teks minimal WCAG AA (4.5:1). Teks putih di atas `#10B981` kontrasnya rendah untuk teks kecil; untuk teks di bawah 18px gunakan `#059669` atau `#006C49` sebagai latar, atau teks Navy di atas Emerald.
- Target sentuh minimal 44x44px.
- Fokus keyboard terlihat jelas (ring Emerald 2px).
- Status tidak bergantung pada warna saja.
- Gambar bukti transfer punya teks alternatif dan opsi perbesar.

---

## 10. Implementasi Tailwind

```js
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: { DEFAULT: '#10B981', dark: '#059669', tint: '#D1FAE5' },
        navy: '#0F1B33',
        app: '#F4F6F8',
        ink: { DEFAULT: '#0F172A', muted: '#64748B' },
        line: '#E5E7EB',
        status: {
          paid: '#059669', pending: '#D97706',
          unpaid: '#64748B', rejected: '#DC2626',
        },
      },
      fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
      borderRadius: { card: '20px', hero: '24px', input: '16px' },
      boxShadow: {
        card: '0 1px 3px rgba(15,23,42,.04), 0 4px 12px rgba(15,23,42,.03)',
        hero: '0 8px 24px -4px rgba(15,27,51,.12), 0 4px 8px -2px rgba(16,185,129,.08)',
        sheet: '0 -8px 32px rgba(15,23,42,.12)',
      },
    },
  },
};
```

Saran struktur Blade: komponen anonim di `resources/views/components/`:
`button`, `card`, `hero-card`, `stat-card`, `badge-status`, `progress`, `input`, `upload-proof`, `list-item`, `bottom-nav`, `empty-state`.

---

## 11. Ketidaksesuaian Hasil Stitch dengan PRD

Beberapa detail di layar yang dihasilkan perlu disesuaikan sebelum dipakai:

| Temuan di desain | Masalah | Saran |
|---|---|---|
| Verifikasi: badge "Tervalidasi Sistem OCR" dan blok "Cek Otomatisasi Sistem" (Auto-Matched, Mutasi BCA Terkonfirmasi) | PRD mengatur verifikasi **manual** oleh penggalang dana, tanpa OCR atau integrasi bank | Hapus, atau tandai sebagai fitur masa depan. Ganti dengan checklist manual untuk penggalang dana |
| Hero card Kewajiban/Dashboard memakai istilah "Warga", "RT 05", "Paguyuban" | Terlalu spesifik; PRD menargetkan komunitas umum | Pakai istilah netral: Anggota, Grup |
| Label tombol hero terpotong ("Progr...", "Unda...", "Peri...") | Lebar tombol tidak cukup di 360px | Pakai ikon di atas label (layout vertikal) atau persingkat label |
| Nama bottom nav tengah "Galang" tanpa aksi jelas | Fungsi FAB belum didefinisikan | Tetapkan: buka sheet "Buat Program / Undang Anggota" |
| Dua nilai hijau (`#006C49` dan `#10B981`) | Inkonsistensi token | Satukan sesuai bagian 2 |
| Bottom nav sama untuk penggalang dana dan anggota | PRD membedakan menu per peran (8.4) | Buat varian nav per peran |
