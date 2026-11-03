# 📚 Sistem Perpustakaan Digital Kampus

Aplikasi manajemen perpustakaan kampus berbasis web yang dibangun menggunakan **Laravel 12**, dilengkapi dengan sistem autentikasi, otorisasi berbasis peran (role), CRUD relasional penuh dengan Eloquent ORM, REST API dengan API Resource, konsumsi API internal via Laravel HTTP Client (*Backend for Frontend*), serta data dummy realistis bergaya Indonesia dengan Seeder & Factory.

Project ini dikembangkan sebagai bagian dari praktikum mata kuliah **Workshop Pemrograman Framework**.

---

## 🚀 Fitur Utama

1. **Autentikasi & Otorisasi**:
   * Login & Logout berbasis session murni tanpa starter kit, dilengkapi proteksi CSRF dan pencegahan session fixation.
   * Middleware custom `CheckAdminRole` untuk membatasi fitur administratif (seperti kelola Kategori) khusus untuk role `admin`.
   * Halaman profil petugas dan fitur ganti password yang terenkripsi aman menggunakan `Hash::make()`.
2. **Katalog Buku & Kategori**:
   * CRUD buku dan kategori lengkap dengan validasi Form Request.
   * Filter pencarian buku berdasarkan judul dan kategori.
   * Relasi `Book belongsTo Category` dengan pencegahan N+1 Query Problem melalui eager loading.
3. **Manajemen Anggota**:
   * CRUD data anggota perpustakaan lengkap dengan pencarian nama/NIM dan validasi unik.
   * Halaman detail anggota yang menampilkan riwayat peminjaman buku.
4. **Sirkulasi Peminjaman & Pengembalian**:
   * Pencatatan transaksi peminjaman (mendukung peminjaman multi-buku sekaligus).
   * Identitas petugas pencatat otomatis terisi dari akun yang sedang login (`auth()->id()`).
   * Fitur pengembalian buku dengan badge status berwarna (kuning: *dipinjam*, hijau: *dikembalikan*, merah: *terlambat*).
5. **REST API & API Resource**:
   * 11 endpoint REST API terstruktur untuk `books`, `members`, `loans`, dan `stats`.
   * Format respons JSON yang konsisten menggunakan `JsonResource`.
   * Dokumentasi endpoint lengkap tersedia di [`API.md`](API.md).
6. **Konsumsi API Internal & Dashboard**:
   * Halaman **Dashboard** mengonsumsi `GET /api/stats` lewat Laravel HTTP Client (`Http::get()`).
   * Halaman **Laporan Peminjaman** mengonsumsi `GET /api/loans` dengan pagination.
   * Dilengkapi penanganan fallback `try/catch (ConnectionException $e)` jika server API internal belum aktif.
7. **Paginasi & Tampilan Bersih**:
   * Tampilan pagination custom teks/link yang bersih dan konsisten tanpa dependensi Tailwind SVG bawaan.

---

## 📋 Persyaratan Sistem

* **PHP**: Versi `>= 8.2` (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `zip`, `fileinfo`)
* **Composer**: Versi `>= 2.x`
* **Database**: MySQL `>= 8.0` atau MariaDB `>= 10.4`
* **Web Browser & Postman** (untuk pengujian API)

---

## ⚙️ Panduan Instalasi & Menjalankan Project

### 1. Clone Repository
```bash
git clone https://github.com/Melodia11/app-perpustakaan.git
cd app-perpustakaan
git checkout dev # atau main
```

### 2. Install Dependency PHP
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Pastikan pengaturan database di `.env` sudah sesuai:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=

# Base URL instance kedua khusus panggilan API internal (Dashboard & Laporan)
INTERNAL_API_URL=http://127.0.0.1:8011

APP_FAKER_LOCALE=id_ID
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Migrasi dan Seeding Database
Jalankan migrasi untuk membuat tabel dan mengisi data dummy realistis:
```bash
php artisan migrate:fresh --seed
```
*Seeder akan mengisi: 3 Pengguna (1 Admin, 2 Petugas), 5 Kategori, 20 Buku, 15 Anggota, dan 10 Transaksi Peminjaman.*

---

## 🖥️ Menjalankan Server Aplikasi (Wajib Dua Terminal)

Karena server bawaan `php artisan serve` bersifat *single-threaded* (hanya memproses satu request dalam satu waktu), pemanggilan API dari dalam aplikasi itu sendiri (`Http::get()`) memerlukan **dua instance server** di port berbeda agar tidak terjadi *deadlock*:

* **Terminal 1 — Server Utama (Trafik Browser & Pengguna)**:
  ```bash
  php artisan serve --port=8000
  ```
  Akses aplikasi web di browser: [http://127.0.0.1:8000](http://127.0.0.1:8000)

* **Terminal 2 — Server Internal API (Khusus melayani request internal Dashboard & Laporan)**:
  ```bash
  php artisan serve --port=8011
  ```

---

## 🔑 Kredensial Akun Default

Semua akun menggunakan password: **`password`**

| Role | Nama | Email | Hak Akses |
|---|---|---|---|
| **Admin** | Bambang Sutrisno | `admin@pens.ac.id` | Akses penuh seluruh menu termasuk kelola Kategori |
| **Petugas 1** | Siti Rahmawati | `petugas1@pens.ac.id` | Operasional: Buku, Anggota, Peminjaman, Laporan, Profil |
| **Petugas 2** | Ahmad Fauzi | `petugas2@pens.ac.id` | Operasional: Buku, Anggota, Peminjaman, Laporan, Profil |

---

## 📖 Dokumentasi Terkait

* **[`API.md`](API.md)**: Dokumentasi lengkap 11 endpoint REST API (metode HTTP, URL, request body, dan contoh respons JSON nyata untuk status sukses & gagal).
* **[`DEMO.md`](DEMO.md)**: Skenario langkah demi langkah untuk demo live aplikasi dan evaluasi UAS.
