<?php

return [
    'accepted' => ':attribute harus diterima.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => ':attribute bukan tanggal yang valid.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => ':attribute harus berupa berkas.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'integer' => ':attribute harus berupa angka bulat.',
    'lowercase' => ':attribute harus menggunakan huruf kecil.',
    'mimes' => ':attribute harus berupa berkas bertipe: :values.',
    'numeric' => ':attribute harus berupa angka.',
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'unique' => ':attribute sudah digunakan.',
    'url' => ':attribute harus berupa URL yang valid.',

    'max' => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file' => ':attribute tidak boleh lebih dari :max kilobyte.',
        'string' => ':attribute tidak boleh lebih dari :max karakter.',
    ],
    'min' => [
        'numeric' => ':attribute minimal :min.',
        'file' => ':attribute minimal :min kilobyte.',
        'string' => ':attribute minimal :min karakter.',
    ],

    'password' => [
        'letters' => ':attribute harus mengandung setidaknya satu huruf.',
        'mixed' => ':attribute harus mengandung huruf besar dan huruf kecil.',
        'numbers' => ':attribute harus mengandung setidaknya satu angka.',
        'symbols' => ':attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => ':attribute pernah bocor di internet. Gunakan kata sandi lain.',
    ],

    'attributes' => [
        'name' => 'Nama',
        'email' => 'Email',
        'password' => 'Kata sandi',
        'password_confirmation' => 'Konfirmasi kata sandi',
        'role' => 'Peran',
        'description' => 'Deskripsi',
        'category' => 'Kategori',
    ],
];