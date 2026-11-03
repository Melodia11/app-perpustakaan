# Dokumentasi REST API Perpustakaan Digital Kampus

Base URL: `http://127.0.0.1:8000/api` (atau `http://localhost/api`)  
Header Wajib: `Accept: application/json`

---

## Ringkasan Endpoint

| No | Method | URL | Deskripsi | Status Code |
|---|---|---|---|---|
| 1 | `GET` | `/api/books` | Mengambil daftar buku (mendukung pagination dan filter `judul` & `category_id`) | `200 OK` |
| 2 | `GET` | `/api/books/{id}` | Mengambil detail satu buku | `200 OK`, `404 Not Found` |
| 3 | `POST` | `/api/books` | Menambahkan buku baru | `201 Created`, `422 Unprocessable Entity` |
| 4 | `PUT` | `/api/books/{id}` | Memperbarui data buku | `200 OK`, `422 Unprocessable Entity`, `404 Not Found` |
| 5 | `DELETE` | `/api/books/{id}` | Menghapus data buku | `200 OK`, `404 Not Found` |
| 6 | `GET` | `/api/members` | Mengambil daftar anggota dengan pagination | `200 OK` |
| 7 | `GET` | `/api/members/{id}` | Mengambil detail satu anggota | `200 OK`, `404 Not Found` |
| 8 | `GET` | `/api/loans` | Mengambil riwayat/daftar transaksi peminjaman | `200 OK` |
| 9 | `POST` | `/api/loans` | Mencatat transaksi peminjaman baru | `201 Created`, `422 Unprocessable Entity` |
| 10 | `PUT` | `/api/loans/{id}/kembalikan` | Menandai peminjaman selesai (status dikembalikan) | `200 OK`, `404 Not Found` |
| 11 | `GET` | `/api/stats` | Statistik ringkas buku, anggota, dan pinjaman aktif | `200 OK` |

---

## Detail Endpoint dan Contoh Request / Response

### 1. `GET /api/books`
Mengambil daftar buku dengan pagination dan relasi kategori.

* **Query Parameters (Opsional):**
  * `judul`: Filter buku berdasarkan kata kunci judul (pencarian `LIKE`)
  * `category_id`: Filter buku berdasarkan ID kategori
  * `page`: Nomor halaman pagination

* **Response: `200 OK`**
```json
{
  "data": [
    {
      "id": 1,
      "judul": "Clean Code",
      "penulis": "Robert C. Martin",
      "penerbit": "Prentice Hall",
      "tahun_terbit": "2008",
      "isbn": "9780132350884",
      "stok": 7,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Teknologi"
      },
      "created_at": "2026-11-03T12:31:56.000000Z",
      "updated_at": "2026-11-03T12:31:56.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost/api/books?page=1",
    "last": "http://localhost/api/books?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://localhost/api/books",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 2. `GET /api/books/{id}`
Mengambil detail satu buku berdasarkan ID.

* **Response Sukses: `200 OK`**
```json
{
  "data": {
    "id": 1,
    "judul": "Clean Code",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": "2008",
    "isbn": "9780132350884",
    "stok": 7,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi"
    },
    "created_at": "2026-11-03T12:31:56.000000Z",
    "updated_at": "2026-11-03T12:31:56.000000Z"
  }
}
```

* **Response Gagal (ID tidak ditemukan): `404 Not Found`**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 3. `POST /api/books`
Menambahkan data buku baru ke perpustakaan.

* **Request Headers:**
  * `Content-Type: application/json`
  * `Accept: application/json`

* **Request Body:**
```json
{
  "judul": "Clean Architecture",
  "penulis": "Robert C. Martin",
  "penerbit": "Prentice Hall",
  "tahun_terbit": 2017,
  "isbn": "978-0134494166",
  "stok": 5,
  "category_id": 1
}
```

* **Response Sukses: `201 Created`**
```json
{
  "data": {
    "id": 3,
    "judul": "Clean Architecture",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2017,
    "isbn": "978-0134494166",
    "stok": 5,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi"
    },
    "created_at": "2026-11-03T13:13:35.000000Z",
    "updated_at": "2026-11-03T13:13:35.000000Z"
  }
}
```

* **Response Gagal (Validasi tidak lengkap/salah): `422 Unprocessable Entity`**
```json
{
  "message": "Judul wajib diisi. (and 4 more errors)",
  "errors": {
    "judul": [
      "Judul wajib diisi."
    ],
    "penulis": [
      "Penulis wajib diisi."
    ],
    "penerbit": [
      "Penerbit wajib diisi."
    ],
    "tahun_terbit": [
      "Tahun terbit wajib diisi."
    ],
    "category_id": [
      "Kategori wajib dipilih."
    ]
  }
}
```

---

### 4. `PUT /api/books/{id}`
Memperbarui informasi data buku.

* **Request Body:**
```json
{
  "judul": "Clean Architecture: A Craftsman's Guide",
  "penulis": "Robert C. Martin",
  "penerbit": "Prentice Hall",
  "tahun_terbit": 2017,
  "isbn": "978-0134494166",
  "stok": 7,
  "category_id": 1
}
```

* **Response Sukses: `200 OK`**
```json
{
  "data": {
    "id": 3,
    "judul": "Clean Architecture: A Craftsman's Guide",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2017,
    "isbn": "978-0134494166",
    "stok": 7,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi"
    },
    "created_at": "2026-11-03T13:13:35.000000Z",
    "updated_at": "2026-11-03T13:13:36.000000Z"
  }
}
```

---

### 5. `DELETE /api/books/{id}`
Menghapus buku dari sistem.

* **Response Sukses: `200 OK`**
```json
{
  "message": "Buku berhasil dihapus."
}
```

* **Response Gagal: `404 Not Found`**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 6. `GET /api/members`
Mengambil daftar anggota perpustakaan dengan pagination.

* **Response: `200 OK`**
```json
{
  "data": [
    {
      "id": 1,
      "nama": "Siti Aminah",
      "nim": "2023001",
      "email": "siti@mahasiswa.ac.id",
      "nomor_telepon": "081234567890",
      "alamat": "Jl. Raya Kampus No. 1",
      "status": "aktif",
      "created_at": "2026-11-03T12:08:44.000000Z",
      "updated_at": "2026-11-03T12:08:44.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost/api/members?page=1",
    "last": "http://localhost/api/members?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://localhost/api/members",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 7. `GET /api/members/{id}`
Mengambil detail informasi anggota.

* **Response Sukses: `200 OK`**
```json
{
  "data": {
    "id": 1,
    "nama": "Siti Aminah",
    "nim": "2023001",
    "email": "siti@mahasiswa.ac.id",
    "nomor_telepon": "081234567890",
    "alamat": "Jl. Raya Kampus No. 1",
    "status": "aktif",
    "created_at": "2026-11-03T12:08:44.000000Z",
    "updated_at": "2026-11-03T12:08:44.000000Z"
  }
}
```

* **Response Gagal: `404 Not Found`**
```json
{
  "message": "No query results for model [App\\Models\\Member] 999"
}
```

---

### 8. `GET /api/loans`
Mengambil riwayat transaksi peminjaman dengan relasi `member`, `petugas`, dan daftar `books`.

* **Response: `200 OK`**
```json
{
  "data": [
    {
      "id": 1,
      "member": {
        "id": 1,
        "nama": "Siti Aminah"
      },
      "petugas": {
        "id": 1,
        "name": "Admin Perpustakaan"
      },
      "tanggal_pinjam": "2026-11-03",
      "tanggal_kembali": "2026-11-10",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "books": [
        {
          "id": 1,
          "judul": "Clean Code"
        }
      ]
    }
  ],
  "links": {
    "first": "http://localhost/api/loans?page=1",
    "last": "http://localhost/api/loans?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://localhost/api/loans",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 9. `POST /api/loans`
Mencatat transaksi peminjaman baru (bisa meminjam banyak buku sekaligus).

* **Request Body:**
```json
{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-11-03",
  "tanggal_kembali": "2026-11-10",
  "book_ids": [1]
}
```

* **Response Sukses: `201 Created`**
```json
{
  "data": {
    "id": 2,
    "member": {
      "id": 1,
      "nama": "Siti Aminah"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-11-03",
    "tanggal_kembali": "2026-11-10",
    "tanggal_dikembalikan": null,
    "status": "dipinjam",
    "books": [
      {
        "id": 1,
        "judul": "Clean Code"
      }
    ]
  }
}
```

* **Response Gagal (Validasi error): `422 Unprocessable Entity`**
```json
{
  "message": "Anggota wajib dipilih. (and 4 more errors)",
  "errors": {
    "member_id": [
      "Anggota wajib dipilih."
    ],
    "user_id": [
      "Petugas (user_id) wajib diisi."
    ],
    "tanggal_pinjam": [
      "Tanggal pinjam wajib diisi."
    ],
    "tanggal_kembali": [
      "Tanggal kembali wajib diisi."
    ],
    "book_ids": [
      "Pilih minimal satu buku."
    ]
  }
}
```

---

### 10. `PUT /api/loans/{id}/kembalikan`
Menyelesaikan peminjaman buku (mengubah `status` jadi `"dikembalikan"` dan mengisi `tanggal_dikembalikan` otomatis).

* **Response Sukses: `200 OK`**
```json
{
  "data": {
    "id": 2,
    "member": {
      "id": 1,
      "nama": "Siti Aminah"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-11-03",
    "tanggal_kembali": "2026-11-10",
    "tanggal_dikembalikan": "2026-11-03",
    "status": "dikembalikan",
    "books": [
      {
        "id": 1,
        "judul": "Clean Code"
      }
    ]
  }
}
```

* **Response Gagal (ID peminjaman tidak ada): `404 Not Found`**
```json
{
  "message": "No query results for model [App\\Models\\Loan] 999"
}
```

---

### 11. `GET /api/stats`
Mengambil statistik jumlah ringkas untuk keperluan widget dashboard.

* **Response Sukses: `200 OK`**
```json
{
  "total_buku": 2,
  "total_anggota": 3,
  "peminjaman_aktif": 1
}
```
