# Skenario Demo Live Aplikasi Perpustakaan Digital Kampus (UAS)

Dokumen ini berisi panduan skenario demo live aplikasi `app-perpustakaan` sesuai alur evaluasi akhir semester (Pertemuan 11).

---

## 🛠️ Persiapan Sebelum Demo

1. **Jalankan Database MySQL** (Laragon / XAMPP):
   Pastikan service MySQL aktif pada `127.0.0.1:3306` dengan database `db_perpustakaan`.

2. **Reset dan Seed Database**:
   Jalankan perintah berikut di root folder project:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Data otomatis terisi: 3 User (1 Admin, 2 Petugas), 5 Kategori, 20 Buku, 15 Anggota, dan 10 Transaksi Peminjaman bergaya Indonesia.*

3. **Jalankan Dua Instance Server (Wajib)**:
   * **Terminal 1 (Server Utama untuk Browser & Klien)**:
     ```bash
     php artisan serve --port=8000
     ```
   * **Terminal 2 (Server Internal API untuk konsumsi Dashboard & Laporan)**:
     ```bash
     php artisan serve --port=8011
     ```

4. **Daftar Kredensial Login**:
   * **Admin**: `admin@pens.ac.id` | Password: `password` (Nama: *Bambang Sutrisno*)
   * **Petugas 1**: `petugas1@pens.ac.id` | Password: `password` (Nama: *Siti Rahmawati*)
   * **Petugas 2**: `petugas2@pens.ac.id` | Password: `password` (Nama: *Ahmad Fauzi*)

---

## 📋 Alur Skenario Demo

### Langkah 1: Login ke Aplikasi
1. Buka browser pada URL: `http://127.0.0.1:8000/login`.
2. Masukkan kredensial:
   * Email: `admin@pens.ac.id`
   * Password: `password`
3. Klik tombol **Login**.
4. **Hasil yang Diamati:**
   * Otomatis dialihkan ke halaman **Dashboard** (`/`).
   * Tampil flash message sukses: `"Login berhasil, selamat datang Bambang Sutrisno."`.
   * Pada navbar pojok kanan tampil identitas: `"Bambang Sutrisno (Admin)"` dan tombol **Logout**.
   * Menu navbar menampilkan: **Dashboard**, **Buku**, **Kategori** (khusus admin), **Anggota**, **Peminjaman**, **Laporan**, **Profil**.

---

### Langkah 2: Tampilkan Dashboard Statistik
1. Tunjukkan 3 kartu statistik di halaman `/`:
   * **Total Buku**: 20
   * **Total Anggota**: 15
   * **Peminjaman Aktif**: Jumlah transaksi dengan status `dipinjam` (sesuai seed).
2. **Penjelasan Konseptual:**
   * Angka ini **bukan** hasil query Eloquent langsung dari `DashboardController`, melainkan dikonsumsi via Laravel HTTP Client (`Http::get()`) memanggil endpoint internal `GET /api/stats` (pada port 8011).
   * Dilengkapi `try/catch (ConnectionException $e)` sehingga jika server API internal mati, halaman tetap tampil anggun (graceful degradation) dengan nilai default `0`.

---

### Langkah 3: Tambah Kategori Baru (Fitur Otorisasi Admin)
1. Klik menu **Kategori** (`/categories`).
2. Klik tombol **+ Tambah Kategori**.
3. Isi form:
   * **Nama Kategori**: `Filsafat`
   * **Deskripsi**: `Buku pemikiran filosofis dan logika.`
4. Klik **Simpan**.
5. **Hasil yang Diamati:**
   * Redirect kembali ke `/categories` dengan flash message `"Kategori "Filsafat" berhasil ditambahkan."`.
   * Kategori baru muncul pada tabel.

---

### Langkah 4: Tambah Buku dengan Relasi Kategori
1. Klik menu **Buku** (`/books`).
2. Klik tombol **+ Tambah Buku**.
3. Isi form:
   * **Judul**: `Dunia Sophie`
   * **Penulis**: `Jostein Gaarder`
   * **Penerbit**: `Mizan`
   * **Tahun Terbit**: `1996`
   * **ISBN**: `9789794335444`
   * **Stok**: `8`
   * **Kategori**: Pilih `Filsafat` (kategori yang baru dibuat di Langkah 3).
4. Klik **Simpan**.
5. **Hasil yang Diamati:**
   * Data tersimpan dan tampil di tabel buku.
   * Kolom Kategori menampilkan teks nama kategori `"Filsafat"` (bukan ID angka), berkat eager loading Eloquent relationship (`Book::with('category')`).

---

### Langkah 5: Tambah Anggota Baru & Uji Validasi
1. Klik menu **Anggota** (`/members`).
2. Klik tombol **+ Tambah Anggota**.
3. Isi data:
   * **Nama**: `Rian Pratama`
   * **NIM**: `3123500099`
   * **Email**: `rian.pratama@pens.ac.id`
   * **Nomor Telepon**: `081234567899`
   * **Alamat**: `Jl. Sukolilo No. 10, Surabaya`
   * **Status**: `aktif`
4. Klik **Simpan**.
5. Tunjukkan data tersimpan di tabel anggota.
6. *(Opsional Uji Validasi)*: Coba tambah lagi dengan NIM atau Email yang sama, tunjukkan sistem menolak dengan pesan error Bahasa Indonesia: `"NIM sudah terdaftar."` / `"Email sudah terdaftar."`.
7. Tunjukkan fitur pencarian anggota (`?search=Rian`) menampilkan anggota yang cocok.

---

### Langkah 6: Buat Transaksi Peminjaman Baru
1. Klik menu **Peminjaman** (`/loans`).
2. Klik tombol **+ Tambah Peminjaman** (`/loans/create`).
3. Form peminjaman:
   * Pilih **Anggota**: `Rian Pratama` (anggota yang baru dibuat).
   * **Petugas**: Tunjukkan teks informatif `"Petugas pencatat: Bambang Sutrisno (otomatis dari akun yang login)."` tanpa dropdown manual.
   * **Tanggal Pinjam**: Tanggal hari ini.
   * **Tanggal Kembali**: 7 hari ke depan.
   * **Buku yang Dipinjam**: Centang buku `Dunia Sophie` dan/atau buku lainnya.
4. Klik **Simpan Transaksi**.
5. **Hasil yang Diamati:**
   * Transaksi baru tercatat dan redirect ke `/loans`.
   * Pada baris baru terlihat nama anggota `Rian Pratama`, petugas `Bambang Sutrisno`, judul buku yang dipinjam, status badge kuning `Dipinjam`, dan tombol aksi **Kembalikan**.

---

### Langkah 7: Lihat Riwayat Peminjaman di Detail Anggota
1. Buka menu **Anggota** (`/members`).
2. Cari `Rian Pratama` dan klik **Detail** (`/members/{id}`).
3. Tunjukkan tabel **Riwayat Peminjaman**:
   * Transaksi yang baru dibuat muncul di riwayat peminjaman anggota tersebut via relasi nested `$member->loans->loanItems->book`.

---

### Langkah 8: Proses Pengembalian Buku
1. Kembali ke daftar **Peminjaman** (`/loans`).
2. Cari transaksi milik `Rian Pratama` yang berstatus `Dipinjam`.
3. Klik tombol hijau **Kembalikan**.
4. **Hasil yang Diamati:**
   * Request `PUT /loans/{id}/kembalikan` dieksekusi.
   * Flash message sukses: `"Buku berhasil dikembalikan."`.
   * Status transaksi berubah menjadi badge hijau `Dikembalikan`.
   * Tombol **Kembalikan** otomatis hilang karena status sudah bukan `dipinjam`.
   * Tanggal dikembalikan terisi tanggal hari ini saat dicek di menu **Detail** transaksi (`/loans/{id}`).

---

### Langkah 9: Tampilkan Halaman Laporan Peminjaman
1. Klik menu **Laporan** di navbar (`/loans/report`).
2. **Hasil yang Diamati:**
   * Menampilkan tabel riwayat seluruh transaksi peminjaman (termasuk transaksi `Rian Pratama` yang baru saja dikembalikan).
   * Navigasi pagination halaman (`« Sebelumnya` / `Selanjutnya »`).
3. **Penjelasan Konseptual:**
   * Halaman ini memanggil `GET /api/loans` lewat `Http::get()`, membuktikan arsitektur *Backend for Frontend (BFF)* berjalan dengan baik.

---

### Langkah 10: Demo REST API di Postman
Buka aplikasi **Postman**:
1. **`GET http://127.0.0.1:8000/api/books`** (Header `Accept: application/json`):
   * Tunjukkan format respons JSON dari `BookResource` yang rapi lengkap dengan data `category` ter-nested dan objek `meta`/`links` pagination.
2. **`GET http://127.0.0.1:8000/api/books?judul=Sophie`**:
   * Tunjukkan hasil filter pencarian judul buku.
3. **`GET http://127.0.0.1:8000/api/stats`**:
   * Tunjukkan JSON statistik real-time: `total_buku`, `total_anggota`, `peminjaman_aktif`.
4. **`POST http://127.0.0.1:8000/api/books`** dengan body kosong:
   * Tunjukkan status HTTP `422 Unprocessable Entity` dan array error validasi per field.

---

### Langkah 11: Demo Halaman Profil & Ganti Password (Tugas P8)
1. Klik menu **Profil** di navbar (`/profil`).
2. Tunjukkan informasi akun: Nama, Email, dan Role (dengan badge).
3. Uji form **Ganti Password**:
   * Masukkan password lama yang salah -> Tampil error `"Password lama tidak sesuai."`.
   * Masukkan password lama yang benar (`password`), password baru (`password123`), dan konfirmasi password baru (`password123`).
   * Klik **Perbarui Password** -> Tampil flash message sukses `"Password berhasil diperbarui."`.
4. Logout dan login kembali menggunakan password baru `password123`.
