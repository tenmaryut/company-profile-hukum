# Log verifikasi konten Kantor Hukum Nalar Saksama (fiktif)

Disusun 2 Oktober 2026 (WIB). Setiap pasal, nomor peraturan/putusan, dan tanggal yang muncul di konten dicocokkan ke sumber resmi di bawah ini. Kutipan berupa potongan pendek atau parafrase dari teks resmi.

## Catatan akses sumber

- **peraturan.bpk.go.id (JDIH BPK)** menolak akses dari server ini ("Access Denied", HTTP 403), baik lewat curl maupun WebFetch. Status "diubah/dicabut" versi BPK karena itu **tidak bisa dicek**. Sebagai gantinya dipakai metadata **JDIH Sekretariat Negara** (API resmi `https://jdih.setneg.go.id/api/hukumproduk/detaildata`, halaman publik `https://jdih.setneg.go.id/detailperaturan?jns=..&no=..&thn=..`) dan salinan PDF resmi (berstempel "Salinan sesuai dengan aslinya") dari JDIH kementerian/lembaga anggota JDIHN.
- **peraturan.go.id** tidak merespons (timeout) dari server ini.
- Teks PDF dibaca dengan `pdftotext -layout`; sebagian salinan adalah hasil pindai sehingga ada salah baca OCR kecil (mis. "l0O" untuk "100"). Bunyi pasal dicek manual pada konteksnya.
- Pengecekan status (perubahan, putusan MK) dilakukan sampai 2 Oktober 2026 lewat JDIH Setneg dan mkri.id. Perubahan sesudah tanggal itu belum tercakup.

## Ringkasan status hukum (per 2 Oktober 2026)

File ini mencakup artikel 01-06. Log verifikasi untuk `halaman.md` ada di `verifikasi-halaman.md` (dikerjakan agen lain).

- **KUHP Nasional (UU 1/2023)** berlaku 2 Januari 2026 dan **sudah diubah oleh UU 1/2026 tentang Penyesuaian Pidana** (disahkan, diundangkan, dan berlaku 2 Januari 2026). Perubahan penting: pidana mati kini selalu dengan masa percobaan 10 tahun (Pasal 99-101 baru), pidana pengawasan hanya bagi pelaku pertama kali (Pasal 76 baru), pertanggungjawaban korporasi (Pasal 49 baru), minimum khusus di luar KUHP dihapus kecuali 4 jenis tindak pidana, kurungan di UU lain/Perda diganti denda, Perda hanya boleh mengancam denda paling banyak kategori III. Peraturan pelaksana hukum yang hidup: **PP 55/2025**. MK sudah memutus uji materi KUHP, mis. **275/PUU-XXIII/2025** (Pasal 220 ayat (1), 12 Agustus 2026).
- **KUHAP baru (UU 20/2025)**, judul resmi "Kitab Undang-Undang Hukum Acara Pidana", disahkan/diundangkan 17 Desember 2025, berlaku 2 Januari 2026, mencabut UU 8/1981. Sudah ada beberapa putusan MK 2026 atas UU ini (yang dibaca: 118/PUU-XXIV/2026, tidak dapat diterima). Ada UU baru **UU 3/2026 tentang Pelindungan Saksi dan Korban** (20 Mei 2026), isinya belum dibaca.
- **PDP:** **PP 33/2026** (peraturan pelaksanaan UU PDP) diundangkan 16 Juli 2026 dan **baru berlaku 16 Januari 2027**. **Status lembaga PDP tidak terverifikasi** dari sumber resmi (berita September 2026 menyebut Perpres-nya masih disusun); artikel tidak membuat klaim soal ini. Putusan MK **151/PUU-XXII/2024** mengubah makna Pasal 53 ayat (1) (DPO) menjadi "dan/atau".
- **ITE:** perubahan terakhir tetap **UU 1/2024**; PP 71/2019 masih tercatat berlaku.
- **Ketenagakerjaan:** **belum ada UU ketenagakerjaan baru** yang diundangkan; RUU-nya diberitakan ditargetkan disahkan DPR 6-8 Oktober 2026 (tenggat 2 tahun dari Putusan MK 168/PUU-XXI/2023 tanggal 31 Oktober 2024). **Artikel 05 perlu ditinjau ulang setelah UU itu terbit.** Putusan MK **132/PUU-XXIII/2025** (17 September 2025) mengubah tenggat gugatan PHK (Pasal 82 UU 2/2004): 1 tahun sejak mediasi/konsiliasi gagal.
- **Bantuan hukum:** UU 16/2011, UU 18/2003 (Pasal 19, 22), PP 83/2008, PP 42/2013 tidak ditemukan perubahan.

**Tidak terverifikasi dan karena itu tidak dimuat di artikel:** status pembentukan lembaga PDP; nama resmi dan jadwal pengesahan RUU ketenagakerjaan; isi PP 55/2025, UU 3/2026, dan PP 42/2013 (hanya judul dan tanggal yang dicek); putusan MK lain atas KUHP/KUHAP/UU PDP yang hanya terlihat di hasil pencarian; status "diubah/dicabut" versi JDIH BPK (situsnya menolak akses).

---

## Artikel 01: KUHP Nasional Sudah Berlaku (`01-kuhp-nasional-pokok-perubahan.md`)

**Sumber yang dibuka**
- S1. Salinan UU 1/2023 (345 halaman, salinan Setneg): https://jdih.bp2mi.go.id/uploads/20260310/20260310123609_889000744_UU_Nomor_1_Tahun_2023_(1)_compressed.pdf (JDIH BP2MI)
- S2. Metadata UU 1/2023 di JDIH Setneg: https://jdih.setneg.go.id/detailperaturan?jns=UU&no=1&thn=2023 (ditetapkan dan diundangkan 2023-01-02, LN 2023 No. 1, TLN 6842)
- S3. UU 1/2026 tentang Penyesuaian Pidana: halaman https://jdih.kemenkoinfra.go.id/uu-no-1-tahun-2026 ; PDF https://jdih.kemenkoinfra.go.id/dokumen/file/uu/2026/uu-nomor-1-tahun-2026.pdf (260 halaman). Metadata JDIH Setneg https://jdih.setneg.go.id/detailperaturan?jns=UU&no=1&thn=2026 (disahkan dan diundangkan 2026-01-02, LN 2026 No. 1, TLN 7153)
- S4. Metadata PP 55/2025 di JDIH Setneg: https://jdih.setneg.go.id/detailperaturan?jns=PP&no=55&thn=2025
- S5. Putusan MK 275/PUU-XXIII/2025: https://s.mkri.id/public/content/persidangan/putusan/putusan_mkri_14808_1786522688.pdf

| Klaim di artikel | Sumber | Bukti (kutipan/parafrase) |
|---|---|---|
| KUHP Nasional menggantikan WvS yang berlaku lewat UU 1/1946 | S3, Penjelasan Umum | "UU KUHP dibentuk untuk menggantikan Wetboek van Strafrecht sebagaimana ditetapkan dalam Undang-Undang Nomor 1 Tahun 1946 tentang Peraturan Hukum Pidana" |
| Diundangkan 2 Januari 2023; Pasal 624: berlaku 3 tahun sejak diundangkan, jadi 2 Januari 2026 | S1 (Pasal 624 dan bagian pengundangan), S2, S3 | Pasal 624: "Undang-Undang ini mulai berlaku setelah 3 (tiga) tahun terhitung sejak tanggal diundangkan." Penjelasan Umum UU 1/2026: berlaku "pada tanggal 2 Januari 2026" |
| UU 1/2026 berlaku 2 Januari 2026, mengubah KUHP dan pidana di UU lain/Perda | S3: Pasal IX, Pasal VII, Bab I-II | Pasal IX: "Undang-Undang ini mulai berlaku pada tanggal 2 Januari 2026." Disahkan dan diundangkan 2 Januari 2026 |
| Pasal 3 ayat (1) dan (2) | S1 | Ayat (1): berlaku aturan baru kecuali aturan lama menguntungkan pelaku dan pembantu; ayat (2): bila tidak lagi tindak pidana, proses hukum "harus dihentikan demi hukum". UU 1/2026 hanya mengubah ayat (3) dan (5), jadi ayat (1)-(2) tetap |
| Pasal 64: pidana pokok, tambahan, khusus | S1 | Pasal 64 huruf a-c |
| Pasal 65 ayat (1): penjara, tutupan, pengawasan, denda, kerja sosial; kurungan tidak ada | S1 | Pasal 65 ayat (1) huruf a-e. Penjelasan UU 1/2026: "pidana kurungan telah dihapus dari pidana pokok" |
| Pasal 75: pengawasan untuk ancaman penjara paling lama 5 tahun | S1 | "diancam dengan pidana penjara paling lama 5 (lima) tahun dapat dijatuhi pidana pengawasan" (tidak diubah UU 1/2026) |
| Pasal 76 ayat (1) baru: maksimal 3 tahun dan hanya bagi yang pertama kali; syarat umum | S3, Pasal VII angka 8 | "...tidak lebih dari 3 (tiga) tahun dan dijatuhkan kepada orang yang pertama kali melakukan Tindak Pidana"; ayat (2): syarat umum tidak melakukan tindak pidana lagi |
| Pasal 85 ayat (1)-(2): kerja sosial | S1 | Ancaman penjara kurang dari 5 tahun dan hakim menjatuhkan penjara paling lama 6 bulan atau denda paling banyak kategori II; hakim wajib mempertimbangkan pengakuan, kemampuan kerja, persetujuan terdakwa, dll. (tidak diubah UU 1/2026) |
| Pasal 79 ayat (1): kategori I Rp1.000.000 s.d. kategori VIII Rp50.000.000.000 | S1 | Daftar kategori I-VIII (tidak diubah UU 1/2026) |
| Pasal 67 dan Pasal 98: pidana mati khusus, alternatif, upaya terakhir | S1 | Pasal 67: "pidana mati yang selalu diancamkan secara alternatif"; Pasal 98: "sebagai upaya terakhir" (keduanya tidak diubah) |
| Pasal 100 baru: masa percobaan 10 tahun; mulai 1 hari setelah inkracht; tidak dapat dilaksanakan selama masa percobaan; diubah jadi seumur hidup dengan Keppres setelah pertimbangan MA | S3, Pasal VII angka 17 | Ayat (1) "Hakim menjatuhkan pidana mati dengan masa percobaan ... selama 10 (sepuluh) tahun"; ayat (3); ayat (4) "pidana mati diubah menjadi pidana penjara seumur hidup dengan Keputusan Presiden setelah mendapatkan pertimbangan Mahkamah Agung"; ayat (6) "pidana mati tidak dapat dilaksanakan". Catatan: versi asli UU 1/2023 memakai syarat (penyesalan/peran terdakwa) dan "dapat diubah" |
| Pasal 99 ayat (1) baru | S3, Pasal VII angka 16 | Eksekusi hanya setelah terpidana tidak menunjukkan sikap terpuji dalam masa percobaan dan tidak mengajukan grasi atau grasinya ditolak |
| Pasal 2: hukum yang hidup dalam masyarakat dan batasannya; ayat (3) PP | S1 | Ayat (1)-(3) (tidak diubah UU 1/2026) |
| PP 55/2025 tentang Tata Cara dan Kriteria Penetapan Hukum yang Hidup dalam Masyarakat, 31 Desember 2025 | S4 | Ditetapkan dan diundangkan 2025-12-31, LN 2025 No. 197, TLN 7152, status "berlaku". **Isi PP tidak dibaca**; artikel hanya menyebut judul dan fungsinya |
| Pasal 66 ayat (6) baru: kewajiban adat menjadi pidana pokok | S3, Pasal VII angka 6 | "...merupakan pidana pokok untuk Tindak Pidana berdasarkan hukum yang hidup dalam masyarakat yang diatur dalam Peraturan Daerah" |
| Pasal 45: korporasi subjek tindak pidana dan cakupannya | S1 | Ayat (1)-(2): PT, yayasan, koperasi, BUMN, BUMD, perkumpulan berbadan hukum/tidak, firma, persekutuan komanditer |
| Pasal 48: syarat pertanggungjawaban korporasi | S1 | Huruf a-e (lingkup usaha, menguntungkan secara melawan hukum, diterima sebagai kebijakan, tidak melakukan pencegahan, membiarkan). UU 1/2026 hanya mengubah Penjelasan Pasal 48 |
| Pasal 49 baru: pengurus fungsional, pemberi perintah, pemegang kendali, pemilik manfaat | S3, Pasal VII angka 5 | Bunyi Pasal 49 ayat (1)-(2) yang baru |
| UU 1/2026 Pasal I: minimum khusus dihapus kecuali HAM berat, terorisme, korupsi, TPPU | S3 | Pasal I ayat (1)-(2) |
| UU 1/2026 Pasal II: kurungan tunggal menjadi denda kategori I/II | S3 | Pasal II ayat (1) huruf a-b |
| Perda hanya boleh memuat denda paling banyak kategori III (Pasal IV-VI) | S3 | Pasal IV (penyesuaian Perda), Pasal V (mengubah Pasal 15 UU 12/2011), Pasal VI (mengubah Pasal 238 UU 23/2014): "hanya dapat memuat ancaman pidana denda paling banyak kategori III" |
| Pasal 218-219: penyerangan kehormatan/harkat martabat Presiden/Wapres; Pasal 220 delik aduan | S1 | Bunyi Pasal 218 ayat (1), Pasal 219, Pasal 220 |
| Putusan MK 275/PUU-XXIII/2025, diucapkan 12 Agustus 2026 | S5, amar | Pasal 220 ayat (1) inkonstitusional bersyarat "sepanjang tidak dimaknai, '(1) Tindak Pidana sebagaimana dimaksud dalam Pasal 218 dan Pasal 219 hanya dapat dituntut berdasarkan aduan oleh Presiden dan/atau Wakil Presiden'". Diucapkan "hari Rabu, tanggal dua belas bulan Agustus, tahun dua ribu dua puluh enam" |

**Status hukum yang perlu diketahui**
- UU 1/2023 **sudah diubah** oleh UU 1/2026 tentang Penyesuaian Pidana (Pasal VII mengubah antara lain Pasal 3, 8, 37, 49, 66, 69, 76, 77, 82-84, 90, 91, 95, 99-101, 103, 120, 121, 132, 136, sejumlah pasal Buku Kedua, 613, dan 622; menyisipkan Pasal 599A; menghapus Pasal 615 dan 616). Artikel memakai bunyi yang sudah diubah. Metadata JDIH Setneg untuk UU 1/2023 belum mencantumkan relasi "diubah"; relasi diambil dari teks UU 1/2026.
- Ada beberapa putusan MK lain atas KUHP Nasional pada 2026 (mis. berita tentang Pasal 240-241) yang **tidak dipakai** di artikel karena tidak diverifikasi ke teks putusannya.

---

## Artikel 02: KUHAP Baru (`02-kuhap-baru-hak-tersangka-saksi-korban.md`)

**Sumber yang dibuka**
- S6. UU 20/2025 tentang Kitab Undang-Undang Hukum Acara Pidana: halaman https://jdih.kemenkoinfra.go.id/uu-no-20-tahun-2025 ; PDF salinan https://jdih.kemenkoinfra.go.id/dokumen/file/uu/2025/uu-nomor-20-tahun-2025.pdf (238 halaman)
- S7. Metadata UU 20/2025 di JDIH Setneg: https://jdih.setneg.go.id/detailperaturan?jns=UU&no=20&thn=2025 (ditetapkan dan diundangkan 2025-12-17, LN 2025 No. 188, TLN 7149, relasi "mencabut" P00822 = UU 8/1981)
- S8. Metadata UU 3/2026 di JDIH Setneg: https://jdih.setneg.go.id/detailperaturan?jns=UU&no=3&thn=2026 (judul "Pelindungan Saksi dan Korban", ditetapkan dan diundangkan 2026-05-20, LN 2026 No. 59, TLN 7179)
- S9. Putusan MK 118/PUU-XXIV/2026 (uji UU 20/2025): https://www.mkri.id/public/content/persidangan/putusan/putusan_mkri_14247_1778571334.pdf

| Klaim di artikel | Sumber | Bukti (kutipan/parafrase) |
|---|---|---|
| Judul resmi: "Kitab Undang-Undang Hukum Acara Pidana"; dapat disebut KUHAP | S6: judul, Pasal 368 | "Undang-Undang ini dapat disebut dengan KUHAP." |
| Disahkan dan diundangkan 17 Desember 2025 | S6 (bagian pengesahan), S7 | "Disahkan di Jakarta pada tanggal 17 Desember 2025 ... Diundangkan di Jakarta pada tanggal 17 Desember 2025" |
| Berlaku 2 Januari 2026 | S6, Pasal 369 | "Undang-Undang ini mulai berlaku pada tanggal 2 Januari 2026." |
| Pasal 362 mencabut UU 8/1981 | S6 | "...Undang-Undang Nomor 8 Tahun 1981 tentang Hukum Acara Pidana ... dicabut dan dinyatakan tidak berlaku." |
| Pasal 361 (peralihan) dan catatan kaki 1 | S6 | Huruf a: penyidikan/penuntutan yang sedang berjalan diselesaikan dengan UU 8/1981; huruf b: belum dimulai, pakai UU baru; huruf c: sudah dilimpahkan dan pemeriksaan dimulai, pakai UU 8/1981 kecuali PK; huruf d: dilimpahkan tetapi pemeriksaan terdakwa belum dimulai, pakai UU baru |
| Pasal 142 (hak tersangka/terdakwa) | S6 | Huruf a (segera menjalankan pemeriksaan), b (advokat), c (diberitahu dalam bahasa yang dimengerti), d (diberitahu hak), e (memberikan atau menolak keterangan), f-g (penerjemah, jasa/bantuan hukum), j-l (dokter, rohaniwan, keluarga), n (keadilan restoratif), o-p (saksi/ahli, ganti rugi dan rehabilitasi), q (bebas dari penyiksaan) |
| Pasal 30: pemeriksaan direkam kamera pengawas | S6 | Ayat (1) "direkam dengan menggunakan kamera pengawas selama pemeriksaan berlangsung"; ayat (2) kegunaan rekaman: penyidikan, penuntutan, pembelaan, dan persidangan atas permintaan hakim |
| Pasal 153: salinan BAP paling lama 1 hari | S6 | "...dalam waktu paling lama 1 (satu) Hari terhitung sejak penandatanganan berita acara pemeriksaan" |
| Pasal 143 (hak saksi) | S6 | Huruf a (tidak dapat dituntut, kecuali tidak beriktikad baik), b-d, f-g (bebas pertanyaan menjerat; menolak keterangan yang memberatkan diri), h-j (pelindungan, identitas dirahasiakan, biaya transportasi) |
| Pasal 144 (hak korban) | S6 | Huruf f-h (informasi perkembangan perkara, putusan, pembebasan terpidana), l dan v (restitusi), m (keadilan restoratif), o (bantuan medis, rehabilitasi psikososial dan psikologis), q (pendamping), x (pernyataan dampak tindak pidana tertulis atau lisan) |
| Pasal 145-148: disabilitas, perempuan, lanjut usia | S6 | Judul Bab VII dan Bagian Ketiga s.d. Kelima |
| UU 3/2026 tentang Pelindungan Saksi dan Korban, 20 Mei 2026 | S8 | Metadata resmi JDIH Setneg. **Isi UU 3/2026 tidak dibaca**; artikel hanya menyebut judul dan tanggalnya |
| Pasal 149: advokat penegak hukum; imunitas beriktikad baik | S6 | Ayat (1)-(2) |
| Pasal 150: hak advokat | S6 | Huruf b (menghubungi/mengunjungi sejak ditangkap atau ditahan), d (mendampingi semua tahap), e (salinan BAP), k (bukti meringankan) |
| Pasal 151: kewajiban advokat | S6 | Ayat (1) huruf a-c; ayat (2): surat kuasa dan berita acara sumpah atau identitas keanggotaan lembaga bantuan hukum |
| Pasal 152: pembicaraan diawasi tanpa didengar, kecuali keamanan negara | S6 | Ayat (1)-(2) |
| Pasal 154: bantuan hukum bagi yang tidak mampu; kewajiban memberi tahu dan menunjuk; penolakan dengan berita acara | S6 | Ayat (1)-(5) |
| Pasal 155: wajib tunjuk advokat (pidana mati/seumur hidup/15 tahun atau lebih; 5 tahun atau lebih bagi yang tidak mampu) | S6 | Ayat (1)-(2) |
| Pasal 79-81: keadilan restoratif | S6 | Pasal 79 ayat (1) bentuk pemulihan (pemaafan, pengembalian barang, ganti rugi, dll.), ayat (3) kesepakatan dilaksanakan paling lama 7 hari, ayat (8) tahap penyelidikan s.d. persidangan; Pasal 80 ayat (1) syarat (denda paling banyak kategori III atau penjara paling lama 5 tahun; pertama kali; bukan pengulangan) |
| Pasal 360: sistem peradilan pidana berbasis teknologi informasi | S6 | Ayat (1)-(2) dan ayat (5) (menjamin kerahasiaan identitas saksi dan korban) |
| KUHAP sudah diuji ke MK pada 2026 | S9 | Putusan 118/PUU-XXIV/2026 menguji UU 20/2025; amar "Menyatakan permohonan para Pemohon tidak dapat diterima", diucapkan Selasa, 12 Mei 2026 |

**Status hukum yang perlu diketahui**
- Hasil pencarian (mkri.id, ANTARA) menunjukkan ada beberapa putusan MK atas KUHAP baru pada 2026, antara lain 54/PUU-XXIV/2026 (Pasal 5 dan 79, tidak dapat diterima), 188/PUU-XXIV/2026 (Pasal 170 ayat (1)), dan 290/PUU-XXIV/2026 (dilaporkan mengabulkan permohonan atas Pasal 326 ayat (1) tentang korporasi). Hanya 118/PUU-XXIV/2026 yang dibaca langsung. Pasal-pasal tersebut **tidak dikutip** di artikel. Dari pencarian, tidak ditemukan putusan yang mengubah Pasal 30, 79-81, 142-155, 360-362, atau 369, tetapi pencarian ini tidak menyeluruh.
- Daftar JDIH Setneg menandai status UU 20/2025 sebagai "sebagian" (kemungkinan diubah/diuji sebagian). Rincian relasinya tidak tercantum di metadata. Artikel tidak menyebut perubahan.
- Pengakuan Bersalah (Pasal 78) sengaja tidak dibahas karena ada permohonan uji materi (213/PUU-XXIV/2026) yang hasilnya belum dicek.

---

## Artikel 03: Hak Subjek Data Pribadi (`03-hak-subjek-data-pribadi-uu-pdp.md`)

**Sumber yang dibuka**
- S10. UU 27/2022 tentang Pelindungan Data Pribadi, salinan dari JDIH Kementerian Komunikasi dan Digital: halaman https://jdih.komdigi.go.id/produk_hukum/view/id/832 ; unduhan https://jdih.komdigi.go.id/produk_hukum/unduh/id/832/t/undangundang+nomor+27+tahun+2022 (PDF 50 halaman)
- S11. Metadata UU 27/2022 di JDIH Setneg: https://jdih.setneg.go.id/detailperaturan?jns=UU&no=27&thn=2022 (ditetapkan dan diundangkan 2022-10-17, LN 2022 No. 196, TLN 6820)
- S12. Salinan PP 33/2026 (berstempel "SALINAN", Kementerian Sekretariat Negara) yang diunggah Pemkab Banyumas: https://static.banyumaskab.go.id/website/file/peraturan_pemerintah_no._33_tahun_2026_100926115902.pdf
- S13. Putusan MK 151/PUU-XXII/2024: https://s.mkri.id/public/content/persidangan/putusan/putusan_mkri_12970_1753859809.pdf

| Klaim di artikel | Sumber | Bukti (kutipan/parafrase) |
|---|---|---|
| Disahkan dan diundangkan 17 Oktober 2022 | S10 (bagian pengesahan), S11 | "Disahkan di Jakarta pada tanggal 17 Oktober 2022 ... Diundangkan di Jakarta pada tanggal 17 Oktober 2022" |
| Pasal 74: masa penyesuaian 2 tahun sudah berakhir | S10 | Pengendali, prosesor, dan pihak terkait wajib menyesuaikan "paling lama 2 (dua) tahun sejak Undang-Undang ini diundangkan" (berakhir Oktober 2024) |
| Pasal 4: data spesifik dan umum | S10 | Ayat (2): kesehatan, biometrik, genetika, catatan kejahatan, data anak, data keuangan pribadi, data lain; ayat (3): nama lengkap, jenis kelamin, agama, status perkawinan, data yang dikombinasikan (huruf c tidak terbaca OCR, jadi tidak disebut) |
| Penjelasan Pasal 4 ayat (2) huruf a: dampak lebih besar data spesifik | S10 (Penjelasan) | "...dapat mengakibatkan dampak lebih besar kepada Subjek Data Pribadi, antara lain tindakan diskriminasi dan kerugian yang lebih besar..." |
| Pasal 5-13: hak subjek data | S10 | Bunyi tiap pasal: informasi (5), melengkapi/memperbarui/memperbaiki (6), akses dan salinan (7), mengakhiri/menghapus/memusnahkan (8), menarik persetujuan (9), keberatan atas keputusan otomatis termasuk pemrofilan (10 ayat (1)), menunda/membatasi (11), menggugat dan ganti rugi (12 ayat (1)), format lazim/terbaca sistem dan mengirim ke pengendali lain (13) |
| Pasal 14: permohonan tercatat, elektronik/nonelektronik | S10 | Untuk hak Pasal 6 s.d. Pasal 11 |
| Pasal 15: pengecualian, hanya dalam rangka pelaksanaan UU | S10 | Ayat (1) huruf a-e (hankam, penegakan hukum, kepentingan umum, pengawasan sektor keuangan, statistik dan penelitian ilmiah), ayat (2) |
| Definisi pengendali data pribadi | S10, Pasal 1 angka 4 | "setiap orang, badan publik, dan organisasi internasional yang ... menentukan tujuan dan melakukan kendali pemrosesan Data Pribadi" |
| Pasal 20: enam dasar pemrosesan | S10 | Ayat (2) huruf a-f |
| Pasal 21: informasi yang wajib disampaikan bila memakai persetujuan | S10 | Ayat (1) huruf a-g (legalitas, tujuan, jenis dan relevansi, retensi, rincian informasi, jangka waktu pemrosesan, hak subjek) |
| Pasal 22: tertulis/terekam; syarat bila digabung tujuan lain; batal demi hukum | S10 | Ayat (1), (4) huruf a-c, (5) |
| Pasal 16 ayat (2): prinsip pemrosesan | S10 | Huruf a "terbatas dan spesifik, sah secara hukum, dan transparan"; huruf b sesuai tujuan |
| Pasal 31, 35, 36, 39 | S10 | Perekaman seluruh kegiatan pemrosesan; melindungi dan memastikan keamanan; menjaga kerahasiaan; mencegah akses tidak sah |
| Pasal 30, 32, 40: 3 x 24 jam | S10 | Perbaikan (30 ayat (1)), akses (32 ayat (2)), penghentian setelah penarikan persetujuan (40 ayat (2)) |
| Pasal 43: kewajiban menghapus | S10 | Ayat (1) huruf a-d |
| Pasal 46: notifikasi kegagalan pelindungan 3 x 24 jam kepada subjek data dan lembaga; isi minimal | S10 | Ayat (1)-(2) |
| Pasal 53 ayat (1): pejabat/petugas PDP | S10 | Huruf a-c (pelayanan publik; pemantauan teratur dan sistematis skala besar; data spesifik/tindak pidana skala besar) |
| Putusan MK 151/PUU-XXII/2024, diucapkan 30 Juli 2025: "dan" dimaknai "dan/atau" | S13, amar | "Menyatakan kata 'dan' dalam Pasal 53 ayat (1) huruf b ... tidak mempunyai kekuatan hukum mengikat secara bersyarat sepanjang tidak dimaknai 'dan/atau'." Diucapkan "hari Rabu, tanggal tiga puluh, bulan Juli, tahun dua ribu dua puluh lima" |
| Pasal 57: jenis sanksi administratif; denda paling tinggi 2%; dijatuhkan lembaga | S10 | Ayat (2) huruf a-d, ayat (3), ayat (4) |
| Pasal 58: lembaga ditetapkan Presiden; diatur dengan Perpres | S10 | Ayat (2), (3), (5) |
| PP 33/2026: judul, diundangkan 16 Juli 2026, berlaku 16 Januari 2027 | S12 | Judul "Peraturan Pelaksanaan Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi"; "Ditetapkan di Jakarta pada tanggal 16 Juli 2026 ... Diundangkan ... 16 Juli 2026"; "LEMBARAN NEGARA REPUBLIK INDONESIA TAHUN 2026 NOMOR 88"; Pasal 225: "mulai berlaku setelah 6 (enam) bulan terhitung sejak tanggal diundangkan" |

**Status hukum yang perlu diketahui**
- **PP 33/2026** (peraturan pelaksanaan UU PDP) sudah terbit, tetapi **baru berlaku 16 Januari 2027**. Per 2 Oktober 2026 PP ini belum ada di basis data JDIH Setneg (data terakhir di sana PP 31/2026 tanggal 2 Juli 2026; permintaan detail PP 33/2026 menghasilkan 404), jadi teks diambil dari salinan yang diunggah situs resmi Pemkab Banyumas. Sebaiknya dicocokkan ulang dengan JDIH Setneg/BPK bila sudah tersedia.
- **Lembaga pelaksana PDP (Pasal 58): status pembentukannya TIDAK terverifikasi dari sumber resmi.** Di JDIH Setneg tidak ada Perpres 2026 tentang lembaga ini (data sampai Perpres 40/2026, 2 Juli 2026). Pemberitaan (Kompas 27 Juli 2026 dan 4 September 2026, CNBC Indonesia 16 September 2026) menyebut Perpres pembentukannya masih disusun dan lembaganya belum beroperasi. Karena tidak pasti, artikel **tidak** menyatakan lembaga sudah atau belum terbentuk.
- Ada putusan MK lain atas UU PDP (mis. permohonan atas Pasal 20 ayat (2) huruf a yang dilaporkan ditolak) yang tidak dibaca dan tidak dikutip.
- Ketentuan pidana UU PDP mungkin terdampak UU 1/2026 tentang Penyesuaian Pidana; artikel tidak membahas sanksi pidana.

---

## Artikel 04: Syarat Sah Perjanjian dan Wanprestasi (`04-syarat-sah-perjanjian-wanprestasi.md`)

**Sumber yang dibuka**
- S14. KUHPerdata (Burgerlijk Wetboek voor Indonesie), teks terjemahan bahasa Indonesia (354 halaman) yang diunggah Kejaksaan Negeri Sukoharjo: https://kejari-sukoharjo.kejaksaan.go.id/file/a6d2803a1ea733394063e8f006d31912.pdf . Catatan: KUHPerdata tidak punya terjemahan resmi berbentuk undang-undang; teks yang beredar adalah terjemahan. Halaman JDIH Mahkamah Agung (https://jdih.mahkamahagung.go.id/legal-product/kitab-undang-undang-hukum-perdata/detail) menolak akses (403) dari server ini.
- S15. UU 11/2008 tentang ITE, salinan JDIH Komdigi: https://jdih.komdigi.go.id/produk_hukum/unduh/id/167/t/undangundang+nomor+11+tahun+2008
- S16. UU 1/2024 tentang Perubahan Kedua atas UU 11/2008, salinan JDIH Komdigi: https://jdih.komdigi.go.id/produk_hukum/unduh/id/884/t/undangundang+nomor+1+tahun+2024
- S17. Metadata JDIH Setneg: UU 11/2008 (https://jdih.setneg.go.id/detailperaturan?jns=UU&no=11&thn=2008, relasi "diubah"), UU 19/2016 (https://jdih.setneg.go.id/detailperaturan?jns=UU&no=19&thn=2016, "mengubah" UU 11/2008), UU 1/2024 (https://jdih.setneg.go.id/detailperaturan?jns=UU&no=1&thn=2024, diundangkan 2024-01-02, LN 2024 No. 1, TLN 6905, status "berlaku"); PP 71/2019 (https://jdih.setneg.go.id/detailperaturan?jns=PP&no=71&thn=2019, ditetapkan 2019-10-04, diundangkan 2019-10-10, tidak ada relasi "dicabut")
- S18. PP 71/2019 tentang Penyelenggaraan Sistem dan Transaksi Elektronik, PDF JDIH Kementerian ATR/BPN: https://jdih.atrbpn.go.id/peraturan/download/938/PP%20Nomor%2071%20Tahun%202019.pdf (halaman: https://jdih.atrbpn.go.id/peraturan/detail/938/peraturan-pemerintah-nomor-71-tahun-2019)

| Klaim di artikel | Sumber | Bukti (kutipan/parafrase) |
|---|---|---|
| Pasal 1338: berlaku sebagai undang-undang; iktikad baik | S14 | "Semua persetujuan yang dibuat sesuai dengan undang-undang berlaku sebagai undang-undang bagi mereka yang membuatnya ... Persetujuan harus dilaksanakan dengan itikad baik." |
| Pasal 1320: empat syarat | S14 | "1. kesepakatan mereka yang mengikatkan dirinya; 2. kecakapan untuk membuat suatu perikatan; 3. suatu pokok persoalan tertentu; 4. suatu sebab yang tidak terlarang." |
| Pasal 1321: kekhilafan, paksaan, penipuan | S14 | "Tiada suatu persetujuan pun mempunyai kekuatan jika diberikan karena kekhilafan atau diperoleh dengan paksaan atau penipuan." |
| Pasal 1329 dan 1330 | S14 | 1329: tiap orang berwenang kecuali dinyatakan tidak cakap; 1330: anak belum dewasa, orang di bawah pengampuan, (dan angka 3 tentang perempuan bersuami, yang sengaja tidak disebut karena sudah tidak diterapkan; artikel memakai "antara lain") |
| Pasal 1335 dan 1337: sebab terlarang | S14 | 1335: persetujuan tanpa sebab atau dengan sebab palsu/terlarang "tidaklah mempunyai kekuatan"; 1337: dilarang UU, bertentangan dengan kesusilaan atau ketertiban umum |
| Syarat subjektif/objektif dan akibatnya | Doktrin umum hukum perdata | Disajikan sebagai "ajaran hukum perdata" tanpa menyebut buku atau penulis tertentu (tidak ada kutipan) |
| Pasal 1449 dan 1454 | S14 | 1449: perikatan karena paksaan, penyesatan, atau penipuan menimbulkan tuntutan pembatalan; 1454: jangka waktu tuntutan pembatalan lima tahun bila tidak dibatasi UU khusus |
| Pasal 1234: memberikan, berbuat, tidak berbuat sesuatu | S14 | Bunyi Pasal 1234. Bentuk-bentuk wanprestasi disajikan sebagai praktik umum, bukan bunyi pasal |
| Pasal 1238: pernyataan lalai | S14 | "Debitur dinyatakan lalai dengan surat perintah, atau dengan akta sejenis itu, atau berdasarkan kekuatan dari perikatan sendiri..." |
| Pasal 1243: biaya, kerugian, bunga | S14 | Bunyi Pasal 1243 |
| Pasal 1244 dan 1245: hal tak terduga, keadaan memaksa | S14 | Bunyi kedua pasal |
| Pasal 1267: pemenuhan atau pembatalan plus ganti rugi | S14 | Bunyi Pasal 1267 |
| Pasal 1266: tidak batal demi hukum, harus dimintakan ke pengadilan | S14 | "...persetujuan tidak batal demi hukum, tetapi pembatalan harus dimintakan kepada Pengadilan. Permintaan ini juga harus dilakukan, meskipun syarat batal ... dinyatakan di dalam persetujuan." |
| UU ITE diubah terakhir dengan UU 1/2024 | S16, S17 | Judul UU 1/2024 "Perubahan Kedua atas UU 11/2008"; tidak ditemukan perubahan ketiga di JDIH Setneg sampai 2 Oktober 2026 |
| Pasal 1 angka 17: definisi kontrak elektronik | S15 | "Kontrak Elektronik adalah perjanjian para pihak yang dibuat melalui Sistem Elektronik." (tidak diubah 2016/2024) |
| Pasal 18 ayat (1) | S15 | "Transaksi Elektronik yang dituangkan ke dalam Kontrak Elektronik mengikat para pihak." |
| Pasal 20: saat terjadinya transaksi; penerimaan elektronik | S15 | Ayat (1)-(2) (tidak diubah 2016/2024) |
| Pasal 5 ayat (1) dan (4) | S16, Pasal I angka 1 | Ayat (1) alat bukti sah; ayat (4) baru: "tidak berlaku dalam hal diatur lain dalam Undang-Undang" |
| Pasal 11: syarat tanda tangan elektronik | S15 | "Tanda Tangan Elektronik memiliki kekuatan hukum dan akibat hukum yang sah selama memenuhi persyaratan..." |
| Pasal 17 ayat (2) dan (2a) | S16, Pasal I angka 6 | (2) wajib beriktikad baik; (2a) "Transaksi Elektronik yang memiliki risiko tinggi bagi para pihak menggunakan Tanda Tangan Elektronik yang diamankan dengan Sertifikat Elektronik." |
| Pasal 18A (disisipkan UU 1/2024) dan catatan kaki 1 | S16, Pasal I angka 7 | Ayat (1) huruf a-c (pengguna dari Indonesia dan memberi persetujuan dari/dalam yurisdiksi Indonesia; tempat pelaksanaan di Indonesia; PSE punya tempat/kegiatan usaha di Indonesia); ayat (2) bahasa sederhana, iktikad baik, transparansi |
| PP 71/2019 Pasal 46 ayat (2) dan Pasal 47 ayat (1) | S18 | 46 ayat (2): kesepakatan; subjek hukum cakap atau berwenang mewakili; hal tertentu; objek tidak bertentangan dengan peraturan, kesusilaan, ketertiban umum. 47 ayat (1): kontrak elektronik yang ditujukan kepada penduduk Indonesia harus dibuat dalam Bahasa Indonesia |

**Status hukum yang perlu diketahui**
- UU ITE: perubahan terakhir UU 1/2024 (berlaku sejak diundangkan 2 Januari 2024). Ada putusan MK atas pasal-pasal pidana UU ITE, tetapi tidak menyangkut pasal kontrak yang dikutip (tidak dibaca rinci).
- PP 71/2019 masih tercatat tanpa relasi "dicabut" di JDIH Setneg. Status di JDIH BPK tidak bisa dicek (akses ditolak).

---

## Artikel 05: Perselisihan Hubungan Industrial (`05-penyelesaian-perselisihan-hubungan-industrial.md`)

**Sumber yang dibuka**
- S19. UU 2/2004 tentang Penyelesaian Perselisihan Hubungan Industrial, PDF JDIH Kementerian Ketenagakerjaan: https://jdih.kemnaker.go.id/asset/data_puu/peraturan_file_7.pdf (60 halaman; checksum sama dengan salinan yang dibaca). Di JDIH Kemnaker juga ada terjemahan bahasa Inggris (https://jdih.kemnaker.go.id/asset/data_puue/UU_NO_2_TH_2004.pdf), yang tidak dipakai.
- S20. Putusan MK 68/PUU-XIII/2015 (teks salinan putusan) dan ikhtisarnya: https://www.mkri.id/public/content/persidangan/sinopsis/ikhtisar_1748_1551_Winda%20Ikhtisar%20Putusan%2068%20PUU%202015.pdf
- S21. Putusan MK 132/PUU-XXIII/2025: https://s.mkri.id/public/content/persidangan/putusan/putusan_mkri_13163_1758097391.pdf
- S22. Putusan MK 168/PUU-XXI/2023: https://www.mkri.id/public/content/persidangan/putusan/putusan_mkri_11215_1730375514.pdf (687 halaman) dan ikhtisarnya https://www.mkri.id/public/content/persidangan/sinopsis/ikhtisar_3724_2192_pdf%20Ikhtisar%20Putusan%20%20168_2023.pdf

| Klaim di artikel | Sumber | Bukti (kutipan/parafrase) |
|---|---|---|
| Pasal 2: empat jenis perselisihan; definisi tiap jenis | S19, Pasal 2 dan Pasal 1 angka 2-5 | Bunyi Pasal 2 huruf a-d; definisi perselisihan hak (angka 2), kepentingan (angka 3: "pembuatan, dan/atau perubahan syarat-syarat kerja"), PHK (angka 4), antarserikat (angka 5: keanggotaan, pelaksanaan hak, kewajiban keserikatpekerjaan) |
| Pasal 3: bipartit wajib, 30 hari kerja, dianggap gagal | S19 | Ayat (1)-(3) |
| Pasal 7: perjanjian bersama mengikat dan wajib didaftarkan di PHI | S19 | Ayat (1)-(3) |
| Pasal 4: pencatatan dengan bukti bipartit; tawaran konsiliasi/arbitrase; 7 hari kerja lalu mediator; ruang lingkup konsiliasi dan arbitrase | S19 | Ayat (1), (3), (4), (5), (6) |
| Mediasi untuk empat jenis perselisihan; mediator pegawai instansi ketenagakerjaan | S19, Pasal 1 angka 11-12 | Definisi mediasi dan mediator |
| Pasal 15: mediator 30 hari kerja | S19 | "selambat-lambatnya 30 (tiga puluh) hari kerja terhitung sejak menerima pelimpahan" |
| Pasal 13 ayat (2): anjuran tertulis | S19 | Huruf a "mediator mengeluarkan anjuran tertulis" |
| Putusan MK 68/PUU-XIII/2015, diucapkan 29 September 2015 | S20 | Amar: frasa "anjuran tertulis" dalam Pasal 13 ayat (2) huruf a dan Pasal 23 ayat (2) huruf a dimaknai "...mediator/konsiliator mengeluarkan anjuran tertulis dalam bentuk risalah penyelesaian melalui mediasi/konsiliasi". Ikhtisar: "Tanggal Putusan : Selasa, 29 September 2015" |
| Pasal 25: konsiliator 30 hari kerja | S19 | Bunyi Pasal 25 |
| Pasal 40: arbiter 30 hari kerja, perpanjangan 1 kali paling lama 14 hari kerja | S19 | Ayat (1) dan (3) |
| Pasal 51 ayat (1): putusan arbitrase akhir dan tetap | S19 | "...putusan yang bersifat akhir dan tetap" |
| Pasal 5, 55, 81, 83 ayat (1), 58, 103, 109, 110, 87 | S19 | Gugatan ke PHI bila mediasi/konsiliasi gagal (5); pengadilan khusus di peradilan umum (55); PN tempat pekerja bekerja (81); gugatan tanpa risalah wajib dikembalikan (83 ayat (1)); tanpa biaya bila di bawah Rp150.000.000 termasuk eksekusi (58); putus paling lama 50 hari kerja (103); kepentingan dan antarserikat putusan akhir (109); kasasi 14 hari kerja untuk hak dan PHK (110); serikat pekerja/organisasi pengusaha sebagai kuasa hukum (87) |
| Putusan MK 132/PUU-XXIII/2025, diucapkan 17 September 2025: tenggat gugatan PHK | S21 | Amar angka 2: Pasal 82 (sebagaimana dimaknai Putusan 94/PUU-XXI/2023) inkonstitusional bersyarat sepanjang tidak dimaknai "Gugatan oleh pekerja/buruh atas pemutusan hubungan kerja dapat diajukan hanya dalam tenggang waktu 1 (satu) tahun sejak tidak tercapainya kesepakatan perundingan mediasi atau konsiliasi". Diucapkan "tanggal tujuh belas, bulan September, tahun dua ribu dua puluh lima" |
| Putusan MK 168/PUU-XXI/2023 diucapkan 31 Oktober 2024 | S22 (ikhtisar) | "Tanggal Putusan : Kamis, 31 Oktober 2024" |
| PHK setelah bipartit gagal hanya setelah penetapan lembaga PPHI yang berkekuatan hukum tetap | S22, amar angka 20 | Frasa dalam Pasal 151 ayat (4) dalam Pasal 81 angka 40 UU 6/2023 dimaknai "...Pemutusan Hubungan Kerja hanya dapat dilakukan setelah memperoleh penetapan dari lembaga penyelesaian perselisihan hubungan industrial yang putusannya telah berkekuatan hukum tetap" |
| Waktu paling lama 2 tahun untuk UU ketenagakerjaan baru (dalam pertimbangan) | S22 | "...waktu paling lama 2 (dua) tahun dinilai oleh Mahkamah cukup bagi pembentuk undang-undang untuk membuat undang-undang ketenagakerjaan baru..." (pertimbangan hukum, bukan amar) |
| Judul UU 6/2023 | S22 (amar) | "Undang-Undang Nomor 6 Tahun 2023 tentang Penetapan Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja Menjadi Undang-Undang" |

**Status hukum yang perlu diketahui**
- **UU ketenagakerjaan baru: BELUM diundangkan per 2 Oktober 2026.** Di JDIH Setneg tidak ada UU ketenagakerjaan baru (UU terbaru di sana UU 5/2026, 17 Juni 2026). Pemberitaan akhir September 2026 (Kompas, ANTARA, fin.co.id, investor.id, NU Online) dan judul berita di situs DPR ("Pembahasan RUU Pelindungan Ketenagakerjaan Dikebut Sesuai Batas Waktu MK"; halaman dpr.go.id menolak akses 403) menyebut RUU Pelindungan Ketenagakerjaan ditargetkan disahkan dalam rapat paripurna 6-8 Oktober 2026. Nama RUU dan tanggal target **tidak dicantumkan** di artikel karena tidak terverifikasi dari dokumen resmi. **Artikel perlu ditinjau ulang setelah UU baru diundangkan**, terutama bila UU itu mengubah UU 2/2004.
- Tidak ditemukan perubahan UU 2/2004 oleh UU 6/2023. Ketentuan pidana UU 2/2004 mungkin terdampak UU 1/2026 (tidak dibahas di artikel).

---

## Artikel 06: Bantuan Hukum Cuma-Cuma (`06-bantuan-hukum-cuma-cuma.md`)

**Sumber yang dibuka** (semua PDF diunduh lewat fungsi unduh resmi JDIH Setneg, `POST https://jdih.setneg.go.id/api/ebook/data_ebk`, dari halaman detail yang disebut)
- S23. UU 16/2011 tentang Bantuan Hukum: https://jdih.setneg.go.id/detailperaturan?jns=UU&no=16&thn=2011 (berkas "UU 16 Tahun 2011.pdf"; disahkan 31 Oktober 2011, diundangkan 2 November 2011, LN 2011 No. 104, TLN 5248; tidak ada relasi "diubah/dicabut")
- S24. UU 18/2003 tentang Advokat: https://jdih.setneg.go.id/detailperaturan?jns=UU&no=18&thn=2003 (berkas "UU0182003.pdf"; 5 April 2003, LN 2003 No. 49, TLN 4288)
- S25. PP 83/2008 tentang Persyaratan dan Tata Cara Pemberian Bantuan Hukum secara Cuma-Cuma: https://jdih.setneg.go.id/detailperaturan?jns=PP&no=83&thn=2008 (berkas "PP Nomor 83 Tahun 2008.pdf"; PDF: ditetapkan 30 Desember 2008, diundangkan 31 Desember 2008; LN 2008 No. 214, TLN 4955. Catatan: kolom tanggal penetapan di metadata Setneg tertulis 2019-12-30, jelas salah ketik; yang dipakai tanggal di PDF)
- S26. PP 42/2013 tentang Syarat dan Tata Cara Pemberian Bantuan Hukum dan Penyaluran Dana Bantuan Hukum: https://jdih.setneg.go.id/detailperaturan?jns=PP&no=42&thn=2013 (ditetapkan dan diundangkan 23 Mei 2013, LN 2013 No. 98, TLN 5421). **Hanya judul dan tanggal yang dicek**; isi pasal tidak dikutip.
- S6 (UU 20/2025, lihat Artikel 02) untuk Pasal 154-155 KUHAP.

| Klaim di artikel | Sumber | Bukti (kutipan/parafrase) |
|---|---|---|
| Pasal 1 angka 1 dan 3 UU 16/2011 | S23 | "Bantuan Hukum adalah jasa hukum yang diberikan oleh Pemberi Bantuan Hukum secara cuma-cuma kepada Penerima Bantuan Hukum"; pemberi = "lembaga bantuan hukum atau organisasi kemasyarakatan" |
| Pasal 5: penerima dan hak dasar | S23 | Ayat (1) "orang atau kelompok orang miskin yang tidak dapat memenuhi hak dasar secara layak dan mandiri"; ayat (2) pangan, sandang, layanan kesehatan, layanan pendidikan, pekerjaan dan berusaha, perumahan |
| Pasal 4: perdata, pidana, TUN; litigasi/nonlitigasi; bentuk bantuan | S23 | Ayat (2)-(3) |
| Pasal 8 ayat (2): syarat pemberi | S23 | Berbadan hukum, terakreditasi, kantor/sekretariat tetap, pengurus, program |
| Pasal 7: verifikasi dan akreditasi oleh Menteri | S23 | Ayat (1) huruf b. "Menteri" menurut Pasal 1 angka 4 = menteri urusan hukum dan HAM; artikel menulis "menteri yang membidangi hukum" karena nomenklatur kementerian sudah berubah |
| Pasal 16: APBN; Pasal 20: larangan meminta/menerima pembayaran | S23 | Bunyi kedua pasal |
| Pasal 12: hak penerima | S23 | Huruf a-c |
| Pasal 10 huruf d: kerahasiaan | S23 | "menjaga kerahasiaan data, informasi, dan/atau keterangan yang diperoleh dari Penerima Bantuan Hukum..." |
| Pasal 14 ayat (1)-(2): syarat permohonan, surat keterangan miskin, lisan | S23 | Huruf a-c; ayat (2) permohonan lisan |
| Pasal 15: jawaban 3 hari kerja; alasan penolakan; surat kuasa khusus | S23 | Ayat (2)-(4) |
| PP 42/2013 mengatur syarat, tata cara, dan penyaluran dana | S26 | Judul PP (sesuai amanat Pasal 15 ayat (5) UU 16/2011) |
| Pasal 22 ayat (1) UU 18/2003 | S24 | "Advokat wajib memberikan bantuan hukum secara cuma-cuma kepada pencari keadilan yang tidak mampu." |
| PP 83/2008 Pasal 1 angka 3 dan Pasal 3 | S25 | Definisi: "...tanpa menerima pembayaran honorarium meliputi pemberian konsultasi hukum, menjalankan kuasa, mewakili, mendampingi, membela, dan melakukan tindakan hukum lain..."; Pasal 3: setiap tingkat proses peradilan dan di luar pengadilan |
| PP 83/2008 Pasal 4, 6, 12, 13, 14 | S25 | Permohonan tertulis langsung/melalui organisasi advokat/LBH; isi; lampiran keterangan tidak mampu; lisan (6 ayat (1)); larangan menolak dan keberatan (12); larangan menerima pemberian (13); sanksi teguran lisan s.d. pemberhentian tetap oleh organisasi advokat (14) |
| Catatan kaki 1: Penjelasan Pasal 4 ayat (3) PP 83/2008 | S25 | "pejabat yang berwenang adalah lurah atau kepala desa setempat yang memberikan surat keterangan tidak mampu yang diketahui oleh camat setempat" |
| KUHAP Pasal 154-155 | S6 | Lihat Artikel 02 |

**Status hukum yang perlu diketahui**
- UU 16/2011 dan PP 83/2008 tidak tercatat diubah/dicabut di JDIH Setneg. UU 18/2003 sudah beberapa kali diuji MK untuk pasal lain; pencarian di mkri.id tidak menemukan putusan yang mengubah Pasal 19 atau Pasal 22. Ada perkara MK 2026 tentang definisi "Advokat" dalam Pasal 1 angka 22 KUHAP (masih berjalan/sebagian ditarik menurut berita mkri.id); artikel tidak mengutip pasal itu.
