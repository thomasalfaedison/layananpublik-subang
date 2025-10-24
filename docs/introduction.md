# Aplikasi Layanan Publik Subang

## Pendahuluan

Aplikasi **Evaluasi Kinerja Penyelenggaraan Pelayanan Publik di Kabupaten Subang** dikembangkan sebagai sarana digital untuk mendukung proses penilaian terhadap kinerja perangkat daerah dalam proses pelayanan publik. Aplikasi ini dirancang agar proses evaluasi dapat dilakukan lebih terstruktur, transparan, dan mudah diakses oleh pihak-pihak terkait.

Melalui aplikasi ini, proses pengumpulan data, penilaian, hingga pelaporan hasil evaluasi dilakukan secara online. Dengan demikian, setiap perangkat daerah dapat lebih mudah memahami posisi kinerjanya, sementara Bagian Organisasi selaku pengelola dapat melakukan monitoring secara menyeluruh. Selain itu, aplikasi juga memberikan ruang bagi evaluator untuk menilai secara objektif dengan dukungan data yang akurat.

Aplikasi ini tidak hanya berfungsi sebagai media penilaian, melainkan juga sebagai instrumen peningkatan kualitas pelayanan publik di Kabupaten Subang. Dengan adanya sistem berbasis web, proses evaluasi menjadi lebih efisien, hasilnya terdokumentasi dengan baik, serta dapat digunakan sebagai dasar untuk penyusunan rekomendasi perbaikan berkelanjutan.

## Pengguna

1. Admin (Bagian Organisasi)

-   Berperan sebagai pengelola utama aplikasi.
-   Memiliki akses penuh untuk mengelola kuesioner, mengakses data semua Perangkat Daerah, menetapkan evaluator, serta memantau keseluruhan proses evaluasi.
-   Menjamin kelancaran sistem dan validitas data yang dikelola dalam aplikasi.

2. Instansi (Perangkat Daerah)

-   Berperan sebagai pihak yang dievaluasi.
-   Menginput data dan informasi terkait kinerja pelayanan publik sesuai dengan aspek dan indikator yang ditetapkan.
-   Menyediakan dokumen pendukung untuk melengkapi data kinerja pelayanan publik.

3. Evaluator (Anggota Bagian Organisasi)

-   Bertugas melakukan penilaian terhadap data dan dokumen yang diunggah oleh perangkat daerah.

4. Masyarakat

-   Berperan sebagai pihak yang melakukan penilaian pelayanan publik.
-   Memberi nilai terkait kinerja pelayanan publik sesuai dengan yang dirasakan oleh masyarakat.

## Proses Utama

1. Pengelolaan Kuesioner oleh Admin
2. Pengisian Kuesioner secara Mandiri oleh User Instansi
3. Penilaian Hasil Pengisian oleh User Evaluator
4. Penilaian oleh Masyarakat

## Proses Pendukung

1. Manajemen User
2. Monitoring Pengisian
3. Dokumentasi File Pendukung

## Sub Proses

#### 1. Manajemen User

**Kebutuhan**

1. Sebagai User Admin, dapat melakukan registrasi dan pembuatan akun pengguna (Admin, Instansi, Evaluator).
2. Sebagai User Admin dan User PD, dapat login ke Aplikasi EKPP
3. Sebagai User Admin, dapat melakukan pengaturan hak akses dan otorisasi.
4. Sebagai User Admin, dapat melakukan Reset password.
5. Sebagai User Admin, dapat menambahkan kontak person sesuai dengan Perangkat Daerah terkait.

**Fitur**

1. Tambah Akun User Untuk Role Admin, Instansi, dan Evaluator.
2. Ubah Data Akun User Untuk Role Admin, Instansi, dan Evaluator.
3. Ubah Password Akun User Untuk Role Admin, Instansi, dan Evaluator.
4. Hapus Akun User Untuk Role Admin, Instansi, dan Evaluator.
5. Akun User dapat login ke Aplikasi EKPP.
6. Menambahkan kontak person sesuai dengan Perangkat Daerah Terkait.

**Kriteria**

1. Username User tidak ada yang sama.
2. Saat ubah Password harus melakukan konfirmasi Pasword baru.

#### 2. Manajemen Data Kuesioner

**Kebutuhan**

1. Sebagai User Admin, dapat melakukan tambah, ubah, dan hapus Data Aspek dan Indikator.
2. Sebagai User Admin, dapat melakukan pengelompokan indikator kuesioner berdasarkan aspek.
3. Sebagai User Admin, dapat melakukan tambah, ubah, dan hapus data kuisioner sesuai dengan peraturan yang berlaku.
4. Sebagai User PD, dapat mengisi pertanyaan dan melakukan upload file pendukung.
5. Sebagai User Evaluator, dapat melakukan penilaian pada hasil pengisian User PD.
6. Sebagai Masyarakat, dapat memberikan nilai Pelayanan Publik pada PD tertentu.

**Fungsi**

1. Tambah, ubah, dan hapus Data Aspek.
2. Tambah, ubah, dan hapus Data Indikator.
3. Tambah, ubah, dan hapus data kuisioner sesuai dengan peraturan yang berlaku.
4. Tambah, ubah, dan hapus pilihan jawaban dari pertanyaan kuisioner sesuai dengan peraturan yang berlaku.

**Kriteria**

1. Pada pertanyaan F-01, jika pertanyaan berjenis Label maka dapat menambahkan Sub Pertanyaan.
2. Pada pertanyaan F-01, jika pertanyaan berjenis Pilihan Tunggal maka user yang menjawab hanya dapat memilih salah satu jawaban.
3. Pada pertanyaan F-01, jika pertanyaan berjenis Pilihan Ganda maka user yang menjawab dapat memilih lebih dari satu jawaban.
4. Pada pertanyaan F-01, jika pertanyaan berjenis Upload maka user yang menjawab perlu melakukan upload data pendukung yang diminta sesuai pertanyaan.
5. Pertanyaan F-01 dan F-02 harus sinkron.
6. Pada pertanyaan F-02, setiap pilihan jawaban memiliki bobot nilai dari 0 sampai 5.
7. Pada pertanyaan F-03, setiap pilihan penilaian memiliki bobot nilai dari 0 sampai 5.

#### 3. Monitoring Pengisian

**Kebutuhan**

1. Sebagai User Admin, dapat melakukan pemantauan progres pengisian kuesioner oleh instansi.
2. Sebagai User Admin dan User Evaluator, dapat Ekspor data/hasil evaluasi.
3. Sebagai User Admin, User PD, dan User Evaluator dapat melihat informasi status penilaian.

**Fitur**

1. Lihat detail progres pengisian dari setiap Perangkat Daerah.
2. Export data hasil evaluasi.
3. Menampilkan informasi status pengisian dan evaluasi.

**Kriteria**

1. Menampilkan 10 Perangkat Daerah dengan progress pengisian terlengkap.

#### 4. Dokumentasi File Pendukung

**Kebutuhan**

1. Sebagai User Admin dan User Evaluator, dapat melihat dan menyimpan file dokumen pendukung yang diupload Perangkat Daerah.
2. Sebagai User User PD, dapat melakukan upload dokumen pendukung pada kuisioner.
3. Sebagai User Evaluator, dapat melakukan pemeriksaan/verifikasi dokumen pendukung yang diupload oleh User PD.

**Fitur**

1. Lihat dokumen pendukung yang sudah diupload.
2. Simpan dokumen pendukung yang sudah diupload.

**Kriteria**

1. File pendukung yang diupload menggunakan format gambar (JPG, PNG).
2. File pendukung yang diupload berupa dokumen (Word, PDF).
