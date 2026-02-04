# 📦 Aplikasi Peminjaman Alat Inventaris (UKK-Inventaris)

Aplikasi berbasis web ini dirancang untuk mendigitalisasi manajemen sarana dan prasarana di lingkungan sekolah. Sistem ini mencakup seluruh siklus peminjaman alat, mulai dari manajemen data master hingga pelacakan log aktivitas pengguna.

---

## 🚀 Fitur Utama

* **Multi-Role Access**: Mendukung 3 tingkat hak akses: **Admin**, **Petugas**, dan **Siswa**.
* **Validasi Stok Ganda**: Sistem secara otomatis menolak peminjaman jika jumlah melebihi stok tersedia (Validasi di sisi *Client* via JavaScript dan *Server* via Controller).
* **Manajemen Inventaris Otomatis**: Stok berkurang saat peminjaman disetujui petugas dan bertambah kembali saat barang dikembalikan.
* **CRUD Data Master**: Pengelolaan penuh untuk data User, Kategori, dan Barang/Alat.
* **Audit Log Aktivitas**: Mencatat setiap tindakan krusial pengguna untuk transparansi dan keamanan sistem.
* **Laporan Siap Cetak**: Fitur cetak laporan transaksi khusus untuk role Petugas dengan format ramah cetak (CSS `@media print`).

---

## 🔧 Teknologi yang Digunakan

* **Framework**: Laravel 10/11
* **Frontend**: Tailwind CSS (via Laravel Breeze)
* **Database**: MySQL
* **Bahasa**: PHP >= 8.1, JavaScript (Vanilla)

---

## 🛠️ Langkah-Langkah Menjalankan Project

1.  **Clone Project**
    ```bash
    git clone [https://github.com/username/project-name.git](https://github.com/username/project-name.git)
    cd project-name
    ```

2.  **Instalasi Dependensi**
    ```bash
    composer install
    npm install && npm run dev
    ```

3.  **Pengaturan Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda:
    ```bash
    cp .env.example .env
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi & Seeding Database**
    Jalankan perintah ini untuk membuat tabel dan mengisi data awal (Admin, Kategori, Alat):
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```

---

## 📂 Panduan Penyesuaian (Customization Guide)

### 1. Database & Migrasi
* **Lokasi**: `database/migrations/`
* **Ubah Koneksi**: Buka file `.env` dan sesuaikan bagian `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`.
* **Data Awal**: Edit `database/seeders/DatabaseSeeder.php` untuk mengubah data default saat instalasi.

### 2. Model (Logika Data)
* `app/Models/Barang.php`: Tempat mengatur relasi ke kategori dan kolom yang boleh diisi (`$fillable`).
* `app/Models/Peminjaman.php`: Mengatur relasi antara pengguna dan barang yang dipinjam.

### 3. Controller (Logika Bisnis)
* `app/Http/Controllers/PeminjamanController.php`: **File Terpenting**. Di sini terdapat logika pengurangan stok saat disetujui, penambahan stok saat kembali, dan validasi batas maksimal pinjam.

### 4. View (Tampilan)
* `resources/views/dashboard.blade.php`: Seluruh antarmuka dashboard Admin, Petugas, dan Siswa berada di file ini.

---

## 🔄 Alur Kerja Sistem (Workflow)

1.  **Tahapan Persiapan**: Admin menginput Kategori dan Data Barang melalui dashboard.
2.  **Tahapan Pengajuan**: Siswa memilih alat berdasarkan kategori. Sistem mengecek stok secara *real-time*. Jika stok cukup, data disimpan dengan status `PENDING`.
3.  **Tahapan Validasi**: Petugas meninjau daftar `PENDING`. Jika diklik **SETUJU**, status berubah menjadi `APPROVED` dan **stok barang otomatis berkurang**.
4.  **Tahapan Pengembalian**: Setelah barang kembali, Petugas/Admin mengklik **ISI KEMBALI**. Status berubah menjadi `RETURNED` dan **stok barang bertambah kembali**.
5.  **Audit**: Admin memantau seluruh proses melalui panel **Audit Log Aktivitas**.

---

**Dibuat oleh:** [Nama Anda] – Siswa SMK Informatika Al Irsyad Cirebon.