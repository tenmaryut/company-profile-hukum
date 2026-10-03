<?php

/*
| Identitas firma FIKTIF untuk situs demo portofolio. Semua kontak di bawah
| adalah placeholder: domain .example dicadangkan (RFC 2606) dan nomor
| WhatsApp/telepon sengaja tidak valid supaya tidak mengarah ke orang sungguhan.
*/

return [
    'name' => 'Kantor Hukum Nalar Saksama',
    'short_name' => 'Nalar Saksama',
    'tagline' => 'Penjelasan hukum yang runtut, langkah yang terukur.',
    'description' => 'Situs demo portofolio: Kantor Hukum Nalar Saksama adalah firma fiktif. Contoh company profile kantor hukum dengan artikel hukum, informasi bidang praktik, dan form permintaan konsultasi.',

    'demo_notice' => 'Situs demo portofolio. Firma ini fiktif dan isinya bukan nasihat hukum.',

    'email' => 'halo@nalarsaksama.example',
    'phone' => '+62 21 0000 0000',
    'whatsapp' => env('FIRM_WHATSAPP', '620000000000'),
    'whatsapp_display' => '+62 000-0000-0000',
    'hours' => 'Senin–Jumat, 09.00–17.00 WIB',
    'address' => [
        'street' => 'Jalan Ilustrasi No. 10, Lantai 3',
        'locality' => 'Jakarta Pusat',
        'region' => 'DKI Jakarta',
        'postal_code' => '10000',
        'country' => 'ID',
    ],

    // Nilai kerja di halaman profil.
    'values' => [
        ['title' => 'Jujur soal peluang', 'text' => 'Peluang dan risiko disampaikan apa adanya, tanpa janji hasil perkara.'],
        ['title' => 'Biaya tertulis di awal', 'text' => 'Lingkup kerja dan perkiraan biaya disepakati tertulis sebelum pekerjaan dimulai.'],
        ['title' => 'Kerahasiaan klien', 'text' => 'Informasi yang Anda sampaikan hanya dipakai untuk kepentingan perkara Anda.'],
        ['title' => 'Penjelasan yang runtut', 'text' => 'Fakta, aturan, dan pilihan langkah dijelaskan berurutan dengan bahasa sehari-hari.'],
    ],

    // Akun demo publik (ditampilkan di halaman login admin, direset tiap malam).
    'demo_account' => [
        'name' => 'Pengunjung Demo',
        'email' => 'demo@nalarsaksama.example',
        'password' => env('DEMO_PASSWORD', 'coba-demo-saksama'),
    ],

    // Situs portofolio pembuat (PORTOFOLIO_URL di domain.env, ditulis ke .env saat deploy).
    'author_url' => env('PORTFOLIO_URL'),
];
