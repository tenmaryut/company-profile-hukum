# Log verifikasi `halaman.md` (Kantor Hukum Nalar Saksama, fiktif)

Disusun 2 Oktober 2026 (WIB) untuk `database/content/halaman.md` (bagian Profil, Etika, Bidang praktik, Tim, FAQ, Privasi). Log artikel ada terpisah di `verifikasi.md`.

Setiap pasal, nomor peraturan/putusan, dan tanggal yang muncul di `halaman.md` dicocokkan ke sumber di bawah. Kutipan berupa potongan pendek atau parafrase dari teks resmi. Berkas PDF diunduh ke scratchpad sesi lalu dibaca dengan `pdftotext -layout`. Sebagian salinan resmi adalah hasil pindai, sehingga teksnya mengandung salah baca OCR kecil (mis. "2O22", "persetqjuan"); bunyi pasal dicek pada konteksnya.

## Catatan akses sumber

- Tidak bisa diakses dari server ini atau dari WebFetch: peraturan.bpk.go.id (403), jdih.mahkamahagung.go.id (403), putusan3.mahkamahagung.go.id (403, Cloudflare), bphn.go.id (403), dpr.go.id (403), jdih.kemenkeu.go.id (timeout/ECONNREFUSED), bisnis.com (403). Status "diubah/dicabut" versi JDIH BPK karena itu **tidak dicek**.
- Bisa diakses dan dipakai: JDIH Sekretariat Negara (API `https://jdih.setneg.go.id/api/hukumproduk/...`, berkas `.../api/hukumproduk/pdf?l=uploads&f=<berkas>&fl=<id>`), JDIH Kemenko Infrastruktur, JDIH BP2MI, JDIH BKN, mkri.id/s.mkri.id, situs PERADI dan KAI.
- Metadata relasi JDIH Setneg tidak lengkap untuk perubahan lewat undang-undang omnibus (mis. UU 6/2023 tidak tercatat "mengubah" UU 13/2003 atau UU 40/2007) dan kolom uji materinya kosong walaupun ada putusan MK (mis. UU 27/2022). Karena itu rantai perubahan dicek dari **teks** undang-undang pengubah.
- Batas pengecekan: daftar UU di JDIH Setneg per 2 Oktober 2026 berhenti di UU 5/2026 (17 Juni 2026). UU yang diundangkan sesudahnya mungkin belum tercatat.

## Sumber yang dibuka

| Kode | Dokumen | URL | Keterangan |
|---|---|---|---|
| H1 | Kode Etik Advokat Indonesia | https://peradi.or.id/files/kode-etik-advokat.pdf | 16 hlm., "Disahkan pada tanggal 23 Mei 2002" oleh IKADIN, AAI, IPHI, HAPI, SPI, AKHI, HKHPM |
| H1b | Kode Etik Advokat Indonesia (pembanding) | https://www.kai.or.id/wp-content/uploads/2016/06/KODE-ETIK-ADVOKAT-INDONESIA.pdf | Bunyi Pasal 4 dan Pasal 8 sama dengan H1 |
| H2 | UU 18/2003 tentang Advokat | https://jdih.setneg.go.id/api/hukumproduk/pdf?l=uploads&f=UU0182003.pdf&fl=P01197 | Metadata: https://jdih.setneg.go.id/detailperaturan?jns=UU&no=18&thn=2003 (status "berlaku", LN 2003 No. 49, TLN 4288) |
| H3 | Anotasi UU 18/2003 berdasarkan Putusan MK (Anotasi 2018) | https://www.mkri.id/public/content/infoumum/undang/pdf/Anotasi_108_Anotasi%20Jefri%20UU%2018%20Tahun%202003%20Advokat.pdf | Pasal yang terdampak putusan MK: Pasal 2, 3, 4, 16, 31. Pasal 1, 19, 21, 22 tanpa anotasi |
| H4 | UU 16/2011 tentang Bantuan Hukum | https://jdih.setneg.go.id/api/hukumproduk/pdf?l=uploads&f=UU+16+Tahun+2011.pdf&fl=P14608 | Status "berlaku"; disahkan 31 Oktober 2011, diundangkan 2 November 2011 (LN 2011 No. 104, TLN 5248) |
| H5 | UU 27/2022 tentang Pelindungan Data Pribadi | https://jdih.setneg.go.id/api/hukumproduk/pdf?l=uploads&f=Salinan+UU+Nomor+27+Tahun+2022.pdf&fl=P19522 | Status "berlaku"; md5 sama dengan salinan JDIH Komdigi https://jdih.komdigi.go.id/produk_hukum/unduh/id/832/t/undangundang+nomor+27+tahun+2022 |
| H6 | UU 20/2025 tentang KUHAP | https://jdih.kemenkoinfra.go.id/dokumen/file/uu/2025/uu-nomor-20-tahun-2025.pdf | 238 hlm.; ukuran berkas cocok dengan salinan di scratchpad. Metadata JDIH Setneg: disahkan dan diundangkan 17 Desember 2025, mencabut UU 8/1981 |
| H7 | UU 1/2023 tentang KUHP | https://jdih.bp2mi.go.id/uploads/20260310/20260310123609_889000744_UU_Nomor_1_Tahun_2023_(1)_compressed.pdf | 345 hlm.; metadata JDIH Setneg: disahkan dan diundangkan 2 Januari 2023 |
| H8 | UU 1/2026 tentang Penyesuaian Pidana | https://jdih.kemenkoinfra.go.id/dokumen/file/uu/2026/uu-nomor-1-tahun-2026.pdf | 260 hlm.; metadata JDIH Setneg: disahkan dan diundangkan 2 Januari 2026 (LN 2026 No. 1, TLN 7153) |
| H9 | UU 6/2023 (Penetapan Perppu 2/2022 tentang Cipta Kerja) | https://jdih.kemenkoinfra.go.id/dokumen/file/uu/2023/uu-nomor-6-tahun-2023.pdf | 1.128 hlm.; disahkan dan diundangkan 31 Maret 2023 (LN 2023 No. 41, TLN 6856) |
| H10 | Putusan MK 168/PUU-XXI/2023 | https://s.mkri.id/public/content/persidangan/putusan/putusan_mkri_11215_1730375514.pdf | 687 hlm. Ikhtisar resmi: https://www.mkri.id/public/content/persidangan/sinopsis/ikhtisar_3724_2192_pdf%20Ikhtisar%20Putusan%20%20168_2023.pdf |
| H11 | UU 2/2004 tentang Penyelesaian Perselisihan Hubungan Industrial | https://jdih.bkn.go.id/common/dokumen/UU%20NOMOR%202%20TAHUN%202004@PENYELESAIAN%20PERSELISIHAN%20HUBUNGAN%20INDUSTRIAL.pdf | Halaman: https://jdih.bkn.go.id/Detail_peraturan/breaking/1804. Judul juga tercantum di metadata JDIH Setneg Perppu 1/2005 dan UU 2/2005 tentang penangguhan mulai berlakunya UU 2/2004 |
| H12 | UU 2/2026 tentang Pelindungan Pekerja Rumah Tangga | https://jdih.setneg.go.id/api/hukumproduk/pdf?l=uploads&f=Salinan+UU+Nomor+2+Tahun+2026.pdf&fl=P20560 | Status "berlaku"; disahkan dan diundangkan 30 April 2026 (LN 2026 No. 47, TLN 7174) |
| H13 | UU 16/2019 tentang Perubahan atas UU 1/1974 tentang Perkawinan | https://jdih.setneg.go.id/api/hukumproduk/pdf?l=uploads&f=Salinan+UU+Nomor+16+Tahun+2019.pdf&fl=P18702 | Metadata: "mengubah" P00760 (UU 1/1974, "PERKAWINAN"); disahkan 14 Oktober 2019, diundangkan 15 Oktober 2019 |
| H14 | UU 4/2023 tentang Pengembangan dan Penguatan Sektor Keuangan | https://jdih.setneg.go.id/api/hukumproduk/pdf?l=uploads&f=Salinan+UU+Nomor+4+Tahun+2023.pdf&fl=P19584 | Dicek untuk memastikan tidak ikut mengubah UU 40/2007 dan UU 20/2008 |
| H15 | Metadata JDIH Setneg (API `produkhukum` dan `detaildata`) | https://jdih.setneg.go.id/detailperaturan?jns=UU&no=30&thn=1999 dan seterusnya | UU 30/1999 "berlaku"; UU 40/2007, UU 20/2008, UU 13/2003 "sebagian"; UU 1/2024 "Perubahan Kedua atas UU 11/2008 tentang ITE" "berlaku" (2 Januari 2024); UU 19/2016 "Perubahan atas UU 11/2008"; daftar seluruh UU 2025 dan 2026 |
| H16 | Berita status RUU Pelindungan Ketenagakerjaan | https://www.cnnindonesia.com/ekonomi/20260924174239-532-1407886/ruu-ketenagakerjaan-bakal-sah-8-oktober-atur-pkwt-hingga-outsourcing | Sumber sekunder (berita), dipakai hanya untuk catatan status; situs DPR menolak akses |
| H17 | Kode aplikasi proyek ini | lihat bagian Privasi | Fakta teknis pemberitahuan privasi |

## Profil

| Klaim | Sumber | Bukti |
|---|---|---|
| Firma fiktif, situs demo portofolio | `config/firm.php` | `demo_notice`: "Firma ini fiktif dan isinya bukan nasihat hukum." Tidak ada pasal, angka, atau tanggal di bagian ini |

## Etika

| Klaim | Sumber | Bukti |
|---|---|---|
| Kode Etik Advokat Indonesia disahkan 23 Mei 2002 | H1 (sampul dan bagian penutup), H1b | "DISAHKAN PADA TANGGAL: 23 MEI 2002"; "Kode etik Advokat ini berlaku sejak tanggal ditetapkan, yaitu sejak tanggal 23 Mei 2002." Pasal 33 UU 18/2003 (H2) menyatakan kode etik yang ditetapkan tujuh organisasi pada 23 Mei 2002 berkekuatan hukum secara mutatis mutandis sampai ada ketentuan baru dari Organisasi Advokat |
| KEAI Pasal 4 huruf c | H1, H1b | "Advokat tidak dibenarkan menjamin kepada kliennya bahwa perkara yang ditanganinya akan menang." |
| KEAI Pasal 4 huruf b | H1, H1b | "Advokat tidak dibenarkan memberikan keterangan yang dapat menyesatkan klien mengenai perkara yang sedang diurusnya." |
| Pasal 19 ayat (1) UU 18/2003 | H2, H3 | "Advokat wajib merahasiakan segala sesuatu yang diketahui atau diperoleh dari Kliennya karena hubungan profesinya, kecuali ditentukan lain oleh Undang-undang." |
| KEAI Pasal 4 huruf h | H1, H1b | Advokat wajib memegang rahasia jabatan atas hal yang diberitahukan klien secara kepercayaan "dan wajib tetap menjaga rahasia itu setelah berakhirnya hubungan antara Advokat dan klien itu." |

## Bidang praktik

### Hukum Perdata

| Klaim | Sumber | Bukti |
|---|---|---|
| KEAI Pasal 4 huruf a | H1, H1b | "Advokat dalam perkara-perkara perdata harus mengutamakan penyelesaian dengan jalan damai." |
| Dasar hukum: Kitab Undang-Undang Hukum Perdata | **Teks resmi tidak dapat dibuka** (JDIH BPK, JDIH MA, JDIH Kemenkeu ditolak/timeout) | Hanya nama kodifikasi yang dipakai, tanpa nomor pasal atau nomor Staatsblad. Daftar UU 2025-2026 (H15) tidak memuat kitab hukum perdata atau hukum acara perdata baru |
| Dasar hukum: UU 30/1999 tentang Arbitrase dan Alternatif Penyelesaian Sengketa | H15 | Judul persis, ditetapkan 12 Agustus 1999 (LN 1999 No. 138, TLN 3872), status "berlaku". Isi pasal tidak dikutip |

### Hukum Pidana

| Klaim | Sumber | Bukti |
|---|---|---|
| KUHP Nasional berlaku 2 Januari 2026 | H7 Pasal 624 dan bagian pengundangan | "Undang-Undang ini mulai berlaku setelah 3 (tiga) tahun terhitung sejak tanggal diundangkan"; diundangkan 2 Januari 2023 |
| KUHAP baru berlaku 2 Januari 2026 | H6 Pasal 369 | "Undang-Undang ini mulai berlaku pada tanggal 2 Januari 2026." |
| UU 1/2026 tentang Penyesuaian Pidana mengubah KUHP | H8 judul, Pasal VII, Pasal IX | Pasal VII memuat perubahan KUHP (lihat juga `verifikasi.md` Artikel 01); Pasal IX: "mulai berlaku pada tanggal 2 Januari 2026" |
| Keadilan restoratif dengan syarat yang ditentukan KUHAP | H6 Pasal 79 ayat (1), Pasal 80 ayat (1) | Pasal 79 ayat (1): bentuk pemulihan (pemaafan, pengembalian barang, ganti rugi, dll.); Pasal 80 ayat (1): syarat ancaman denda paling banyak kategori III atau penjara paling lama 5 tahun, pertama kali, bukan pengulangan. Teks halaman tidak menyebut nomor pasal |

### Ketenagakerjaan

| Klaim | Sumber | Bukti |
|---|---|---|
| Jalur PPHI: bipartit dulu, lalu mediasi/konsiliasi/arbitrase, lalu gugatan ke PHI | H11 Pasal 3 ayat (1), Pasal 4 ayat (1), (3)-(6), Pasal 5 | Pasal 3 ayat (1): "wajib diupayakan penyelesaiannya terlebih dahulu melalui perundingan bipartit"; Pasal 4: bila bipartit gagal, perselisihan dicatatkan, para pihak ditawari konsiliasi atau arbitrase, jika tidak memilih dilimpahkan ke mediator, dan konsiliasi/arbitrase hanya untuk jenis perselisihan tertentu; Pasal 5: bila konsiliasi atau mediasi tidak mencapai kesepakatan, salah satu pihak dapat menggugat ke Pengadilan Hubungan Industrial |
| Putusan MK 168/PUU-XXI/2023 diucapkan 31 Oktober 2024 | H10 bagian penutup | "...diucapkan dalam Sidang Pleno Mahkamah Konstitusi terbuka untuk umum pada hari Kamis, tanggal tiga puluh satu, bulan Oktober, tahun dua ribu dua puluh empat". Ikhtisar: "Tanggal Putusan: Kamis, 31 Oktober 2024" |
| Putusan itu mengubah pemaknaan sejumlah ketentuan ketenagakerjaan | H10 amar (ikhtisar butir 2-22) | Puluhan norma dalam Pasal 81 Lampiran UU 6/2023 dinyatakan inkonstitusional (bersyarat) "sepanjang tidak dimaknai ..." |
| MK meminta UU ketenagakerjaan baru paling lama dua tahun | H10 paragraf [3.16] (hlm. ±677) | "pembentuk undang-undang segera membentuk undang-undang ketenagakerjaan yang baru ... waktu paling lama 2 (dua) tahun dinilai oleh Mahkamah cukup". Catatan: ini bagian pertimbangan hukum, bukan amar; teks halaman menyebutnya "dalam pertimbangannya" |
| Dasar hukum: UU 13/2003 sebagaimana diubah UU 6/2023 | H9 Lampiran Pasal 81; H15 | "Beberapa ketentuan dalam Undang-Undang Nomor 13 Tahun 2003 tentang Ketenagakerjaan ... diubah"; judul resmi UU 6/2023 dari halaman pertama H9 dan metadata JDIH Setneg |
| Dasar hukum: UU 2/2004 | H11 | Judul persis; disahkan dan diundangkan 14 Januari 2004 |
| Dasar hukum dan layanan PRT: UU 2/2026 | H12 Pasal 1 angka 1, 5, 8, 9; Pasal 37 | Hubungan kerja PRT "berdasarkan kesepakatan atau perjanjian kerja" (angka 5); Pasal 37: "mulai berlaku pada tanggal diundangkan" (30 April 2026) |

### Pelindungan Data Pribadi

| Klaim | Sumber | Bukti |
|---|---|---|
| UU PDP mengikat pihak yang menentukan tujuan dan mengendalikan pemrosesan | H5 Pasal 1 angka 4 | Pengendali Data Pribadi: pihak yang "dalam menentukan tujuan dan melakukan kendali pemrosesan Data Pribadi" |
| Wajib punya dasar pemrosesan | H5 Pasal 20 ayat (1) | "Pengendali Data Pribadi wajib memiliki dasar pemrosesan Data Pribadi." |
| Memberi tahu tujuan, menjaga keamanan, menghapus data yang tidak diperlukan | H5 Pasal 16 ayat (2) huruf e, f; Pasal 43 ayat (1) huruf a | Prinsip keamanan dan pemberitahuan tujuan; kewajiban menghapus bila data "tidak lagi diperlukan untuk pencapaian tujuan pemrosesan" |
| Diundangkan 17 Oktober 2022; masa penyesuaian dua tahun sudah berakhir | H5 bagian pengundangan, Pasal 74 | "Diundangkan di Jakarta pada tanggal 17 Oktober 2022"; Pasal 74: penyesuaian "paling lama 2 (dua) tahun sejak Undang-Undang ini diundangkan" (berakhir Oktober 2024) |
| Dasar hukum: UU 11/2008 tentang ITE, terakhir diubah UU 1/2024 | H15 | UU 19/2016 = perubahan pertama; UU 1/2024 = "Perubahan Kedua atas Undang-Undang Nomor 11 Tahun 2008 tentang Informasi dan Transaksi Elektronik" (2 Januari 2024, "berlaku"). Tidak ada perubahan lain di daftar UU 2025-2026 |

### Hukum Keluarga

| Klaim | Sumber | Bukti |
|---|---|---|
| Dasar hukum: UU 1/1974 sebagaimana diubah UU 16/2019 | H13 Pasal I; metadata JDIH Setneg | "Beberapa ketentuan dalam Undang-Undang Nomor 1 Tahun 1974 tentang Perkawinan ... diubah"; tidak ada UU perubahan Perkawinan yang lebih baru di JDIH Setneg |
| Dasar hukum: Kitab Undang-Undang Hukum Perdata | lihat Hukum Perdata | Nama saja, tanpa pasal |

### Hukum Bisnis dan Kontrak

| Klaim | Sumber | Bukti |
|---|---|---|
| Perseroan untuk usaha mikro dan kecil dapat didirikan satu orang dengan surat pernyataan pendirian | H9 Pasal 109 angka 1 dan angka 5 (Pasal 1 angka 1 dan Pasal 153A UU 40/2007) | Pasal 1 angka 1 baru memasukkan "badan hukum perorangan yang memenuhi kriteria usaha mikro dan kecil"; Pasal 153A ayat (1) "Perseroan yang memenuhi kriteria usaha mikro dan kecil dapat didirikan oleh 1 (satu) orang", ayat (2) "berdasarkan surat pernyataan pendirian" |
| Dasar hukum: UU 40/2007 sebagaimana diubah UU 6/2023 | H9 Pasal 109; H14; H15 | Pasal 109: "Beberapa ketentuan dalam Undang-Undang Nomor 40 Tahun 2007 tentang Perseroan Terbatas ... diubah". UU 4/2023 (H14) hanya mengubah UU 40/2014 (Perasuransian) dan UU 40/2004 (SJSN), bukan UU 40/2007 |
| Dasar hukum: UU 20/2008 sebagaimana diubah UU 6/2023 | H9 Pasal 87; H14; H15 | Pasal 87: "Beberapa ketentuan dalam Undang-Undang Nomor 20 Tahun 2008 tentang Usaha Mikro, Kecil, dan Menengah ... diubah". Tidak diubah UU 4/2023 |
| Syarat sahnya perjanjian menurut KUHPerdata | - | Disebut umum tanpa nomor pasal karena teks resmi KUHPerdata tidak dapat dibuka (lihat di atas) |

## Tim

Kelima orang fiktif (nama dan slug dari brief). Bio tidak memuat pasal, angka, tahun, prestasi, klien, atau universitas. Kalimat bio Nadia (nasihat hukum diberikan advokat, bukan paralegal) sejalan dengan KEAI Pasal 8 huruf e (H1): advokat tidak dibenarkan mengizinkan karyawan yang tidak berkualifikasi mengurus perkara atau memberi nasihat hukum kepada klien.

## FAQ

| Klaim | Sumber | Bukti |
|---|---|---|
| Pasal 21 ayat (2) UU 18/2003 dan penjelasannya | H2 | Honorarium "ditetapkan secara wajar berdasarkan persetujuan kedua belah pihak"; Penjelasan: "secara wajar" = "dengan memperhatikan resiko, waktu, kemampuan, dan kepentingan klien" |
| KEAI Pasal 4 huruf d dan huruf e | H1 | Huruf d: menentukan honorarium "wajib mempertimbangkan kemampuan klien"; huruf e: "tidak dibenarkan membebani klien dengan biaya-biaya yang tidak perlu" |
| Pasal 19 ayat (1) dan ayat (2) UU 18/2003 | H2, H3 | Ayat (2): hak atas kerahasiaan hubungan dengan klien, "termasuk perlindungan atas berkas dan dokumennya terhadap penyitaan atau pemeriksaan" |
| KEAI Pasal 4 huruf h, huruf c, huruf b | H1 | Lihat bagian Etika |
| UU 16/2011 Pasal 1 angka 1-3 | H4 | Angka 1: bantuan hukum = jasa hukum "secara cuma-cuma"; angka 2: penerima = "orang atau kelompok orang miskin"; angka 3: pemberi = "lembaga bantuan hukum atau organisasi kemasyarakatan" |
| UU 16/2011 Pasal 8 ayat (2) | H4 | Syarat pemberi: berbadan hukum, terakreditasi, kantor/sekretariat tetap, pengurus, program bantuan hukum |
| UU 16/2011 Pasal 4 ayat (2) | H4 | "meliputi masalah hukum keperdataan, pidana, dan tata usaha negara baik litigasi maupun nonlitigasi" |
| UU 16/2011 Pasal 14 | H4 | Ayat (1): permohonan tertulis berisi identitas dan uraian singkat, dokumen perkara, surat keterangan miskin dari "lurah, kepala desa, atau pejabat yang setingkat"; ayat (2): lisan bila tidak mampu menyusun secara tertulis |
| Pasal 22 ayat (1) UU 18/2003 | H2, H3 | "Advokat wajib memberikan bantuan hukum secara cuma-cuma kepada pencari keadilan yang tidak mampu." |
| Pasal 154 UU 20/2025 | H6 | Ayat (1): bantuan hukum bagi tersangka/terdakwa dan pelapor, pengadu, saksi, atau korban "yang tidak mampu pada setiap tahap pemeriksaan"; ayat (2): pejabat "wajib memberitahukan hak mendapatkan Bantuan Hukum dan menunjuk Advokat atau Pemberi Bantuan Hukum" |
| Pasal 1 angka 2 UU 18/2003 | H2 | Jasa hukum: "memberikan konsultasi hukum, bantuan hukum, menjalankan kuasa, mewakili, mendampingi, membela, dan melakukan tindakan hukum lain untuk kepentingan hukum klien" |
| Data form dihapus otomatis setelah 7 hari; reset tiap malam | H17 | Lihat bagian Privasi |
| Tombol WhatsApp, telepon, dan surel adalah placeholder | `config/firm.php` | Domain `.example` (RFC 2606), nomor `620000000000` dan `+62 21 0000 0000` |

## Privasi

### Pasal UU PDP (sumber H5)

| Pasal | Bukti |
|---|---|
| Pasal 21 ayat (1) | Bila berdasarkan persetujuan, pengendali wajib menyampaikan informasi: a. legalitas; b. tujuan; c. jenis dan relevansi data; d. jangka waktu retensi; f. jangka waktu pemrosesan; g. hak subjek data. Huruf e terpotong di salinan pindai, sehingga tidak disebut di teks |
| Pasal 1 angka 4 | Definisi Pengendali Data Pribadi (lihat atas) |
| Pasal 20 ayat (2) huruf a | "persetujuan yang sah secara eksplisit dari Subjek Data Pribadi untuk 1 (satu) atau beberapa tujuan tertentu" |
| Pasal 22 ayat (1) dan ayat (2) | Persetujuan "melalui persetujuan tertulis atau terekam" dan "dapat disampaikan secara elektronik atau nonelektronik" |
| Pasal 16 ayat (2) huruf g | "Data Pribadi dimusnahkan dan/atau dihapus setelah masa retensi berakhir atau berdasarkan permintaan Subjek Data Pribadi" |
| Pasal 42 ayat (1) huruf a | Wajib mengakhiri pemrosesan bila "telah mencapai masa retensi" |
| Pasal 43 ayat (1) huruf a | Wajib menghapus bila data "tidak lagi diperlukan untuk pencapaian tujuan pemrosesan" |
| Pasal 5, 6, 7, 8, 9 | Hak atas informasi; melengkapi/memperbarui/memperbaiki; akses dan salinan; mengakhiri pemrosesan, menghapus, memusnahkan; menarik kembali persetujuan |
| Pasal 11 | Hak "menunda atau membatasi pemrosesan" (satu kata di salinan pindai terpotong, sehingga teks hanya memparafrasekan inti haknya) |
| Pasal 12 ayat (1) | "berhak menggugat dan menerima ganti rugi atas pelanggaran pemrosesan Data Pribadi tentang dirinya" |
| Pasal 30 ayat (1), Pasal 32 ayat (2), Pasal 40 ayat (2) | Perbaikan, pemberian akses, dan penghentian pemrosesan setelah penarikan persetujuan masing-masing "paling lambat 3 x 24 (tiga kali dua puluh empat) jam" |
| Pasal 14 | Pelaksanaan hak dalam Pasal 6 sampai dengan Pasal 11 "diajukan melalui permohonan tercatat yang disampaikan secara elektronik atau nonelektronik" |

### Fakta teknis (sumber H17, kode proyek)

| Klaim | Bukti |
|---|---|
| Data yang dikumpulkan: nama, surel, telepon (opsional), bidang (opsional), uraian, waktu persetujuan | `app/Http/Controllers/ConsultationRequestController.php` (`name`, `email`, `phone`, `practice_area_id`, `message`, `consented_at`); `app/Http/Requests/StoreConsultationRequest.php` (`phone` nullable) |
| Persetujuan lewat kotak centang, form tidak terkirim tanpa centang | `StoreConsultationRequest`: `'consent' => ['accepted']`; `resources/views/pages/contact.blade.php` checkbox `required` |
| IP di-hash untuk pembatas kiriman, tidak disimpan bersama data form | `app/Providers/AppServiceProvider.php`: kunci `hash('sha256', 'konsultasi\|'.$request->ip())`, batas 5 per 10 menit dan 20 per hari |
| Sistem sesi mencatat IP dan jenis peramban; sesi sekitar dua jam | `SESSION_DRIVER=database` dan `SESSION_LIFETIME=120` (`deploy/deploy.sh`); `vendor/laravel/framework/src/Illuminate/Session/DatabaseSessionHandler.php` menyimpan `ip_address` dan `user_agent` |
| Cookie sesi dan XSRF-TOKEN berakhir sekitar dua jam | Respons `GET /kontak` di server lokal: `XSRF-TOKEN` dan `nalar-saksama-session` dengan `Max-Age=7200` |
| Cookie `ns_pengirim`: kode acak, terenkripsi, 7 hari | `ConsultationRequestController`: `Str::random(40)`, `Cookie::queue(..., 60 * 24 * RETENTION_DAYS)`; database hanya menyimpan hash SHA-256; tidak ada pengecualian `EncryptCookies` di `bootstrap/app.php` (middleware web bawaan mengenkripsi cookie) |
| Akun demo hanya melihat data contoh dan kiriman dari browser yang sama | `app/Models/ConsultationRequest.php` scope `visibleTo` |
| Notifikasi pengelola tanpa nama/kontak | `app/Notifications/NewConsultationRequest.php`: kanal `database`, isi hanya bidang hukum dan keterangan retensi |
| Retensi 7 hari, penghapusan dicek tiap jam | `ConsultationRequest::RETENTION_DAYS = 7`, `prunable()`; `routes/console.php`: `model:prune` `->hourly()` |
| Reset data demo tiap malam 00.00 WIB | `deploy/systemd/company-profile-hukum-demo-reset.timer` (`OnCalendar=*-*-* 00:00:00 Asia/Jakarta`); `app/Console/Commands/ResetDemo.php` mengosongkan `consultation_requests` |
| Tanpa analitik/pelacak pihak ketiga; aset dari server sendiri | `deploy/company-profile-hukum.caddy`: CSP `default-src 'self'` (publik dan admin); `deploy/deploy.sh` tidak membuat cadangan database |
| Kontak placeholder | `config/firm.php`: `halo@nalarsaksama.example` |

## Tidak terverifikasi atau sengaja tidak dipakai

- **Kompilasi Hukum Islam (Instruksi Presiden Nomor 1 Tahun 1991)**: tidak ada di JDIH Setneg; salinan di BPHN, JDIH BPK, dan Direktori Putusan MA ditolak (403). **Dikeluarkan** dari dasar hukum Hukum Keluarga.
- **Kitab Undang-Undang Hukum Perdata**: teks resmi tidak dapat dibuka (JDIH BPK, JDIH MA 403; JDIH Kemenkeu timeout). Hanya namanya yang dipakai; nomor pasal (mis. Pasal 1320) dan nomor Staatsblad **tidak dikutip**.
- **HIR/RBg, PERMA tentang mediasi dan gugatan sederhana**: tidak dipakai karena JDIH MA tidak dapat diakses.
- **Pasal 63 UU 1/1974 (kewenangan Pengadilan Agama/Pengadilan Umum)**: teks UU 1/1974 tidak tersedia di sumber yang dapat diakses, jadi tidak disebut.
- **PP 33/2026 tentang Peraturan Pelaksanaan UU 27/2022**: salinan resmi Setneg ada di scratchpad (diunduh agen lain; ditetapkan dan diundangkan 16 Juli 2026, LN 2026 No. 88; Pasal 225: berlaku 6 bulan sejak diundangkan, yaitu 16 Januari 2027). URL resminya tidak ditemukan (belum ada di JDIH Setneg dan JDIH Komdigi), dan PP ini **belum berlaku**, jadi tidak dimasukkan.
- **UU 3/2026 tentang Pelindungan Saksi dan Korban**: tidak dipakai karena isinya tidak dibaca.
- Putusan MK atas pasal yang dikutip dari UU 18/2003: Anotasi MK 2018 (H3) tidak memuat Pasal 1, 19, 21, atau 22. Putusan sesudah 2018 tidak ditelusuri menyeluruh. Hasil pencarian menyebut Putusan 150/PUU-XXII/2024 (Pasal 3 ayat (1) huruf c dan Pasal 20 ayat (2)) dan 217/PUU-XXIII/2025 (tidak dapat diterima), keduanya tidak menyangkut pasal yang dikutip; teks keduanya **tidak dibaca**.
- Putusan MK atas UU 16/2011: **tidak ditelusuri**. Metadata JDIH Setneg berstatus "berlaku".
- Putusan MK 151/PUU-XXII/2024 atas UU 27/2022 (dibaca dari salinan di scratchpad, URL tidak dicatat): diucapkan 30 Juli 2025, hanya memaknai kata "dan" dalam Pasal 53 ayat (1) huruf b menjadi "dan/atau". Tidak menyangkut pasal yang dikutip.

## Status hukum yang perlu diperhatikan

- **Ketenagakerjaan, perlu diperbarui dalam waktu dekat.** Per 2 Oktober 2026 belum ada UU ketenagakerjaan baru di JDIH Setneg. Berita (H16, 24 September 2026) menyebut DPR menargetkan RUU Pelindungan Ketenagakerjaan disahkan dalam rapat paripurna 6-8 Oktober 2026 untuk memenuhi tenggat Putusan MK 168/PUU-XXI/2023. Setelah diundangkan, dasar hukum bidang Ketenagakerjaan (UU 13/2003 jo. UU 6/2023, mungkin juga UU 2/2004) harus dicek ulang. Paragraf deskripsinya sengaja ditulis supaya tetap benar setelah UU baru terbit.
- UU 2/2026 tentang Pelindungan Pekerja Rumah Tangga berlaku sejak 30 April 2026 dan dipakai di bidang Ketenagakerjaan.
- PP 33/2026 (pelaksana UU PDP) baru berlaku 16 Januari 2027. Sesudah tanggal itu, bidang Pelindungan Data Pribadi dan pemberitahuan privasi sebaiknya ditinjau ulang.
- KUHP Nasional dan KUHAP baru berlaku 2 Januari 2026; UU 8/1981 dicabut oleh UU 20/2025. Status JDIH Setneg untuk UU 20/2025 "sebagian" (lihat `verifikasi.md` Artikel 02).
