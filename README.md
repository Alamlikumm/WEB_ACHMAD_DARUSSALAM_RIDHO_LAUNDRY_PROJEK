# Sistem Informasi Laundry (Ridho Laundry)

Aplikasi manajemen laundry berbasis web yang dibangun menggunakan framework **Laravel**. Proyek ini mencakup antarmuka pengelolaan pesanan laundry, data pelanggan, layanan, dan dilengkapi dengan sistem *Auto-Deployment* (CI/CD) yang terhubung langsung ke server hosting cPanel (Hostdata.id).

## 🚀 Fitur Utama
* Manajemen Pelanggan
* Pencatatan Transaksi/Pesanan Laundry
* Manajemen Jenis Layanan
* Auto-Deployment via GitHub Actions (Sinkronisasi kilat via FTP)

## 🛠️ Persyaratan Sistem
Sebelum menjalankan aplikasi ini di komputer lokal, pastikan Anda telah menginstal:
* PHP >= 8.x
* Composer
* MySQL / MariaDB (XAMPP/Laragon)
* Node.js & NPM (Jika ada kompilasi frontend)

## 💻 Cara Menjalankan di Localhost
1. **Clone Repositori:**
   ```bash
   git clone https://github.com/Alamlikumm/WEB_ACHMAD_DARUSSALAM_RIDHO_LAUNDRY_PROJEK.git
   cd WEB_ACHMAD_DARUSSALAM_RIDHO_LAUNDRY_PROJEK
   ```
2. **Install Dependensi PHP:**
   ```bash
   composer install
   ```
3. **Siapkan Konfigurasi Environment:**
   Salin (copy) file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan atur nama database Anda di baris `DB_DATABASE=`.
4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```
5. **Siapkan Database:**
   Buat database baru di MySQL (misal: `laundry_db`), lalu import file `laundry_db.sql` yang ada di root folder ke dalam database tersebut.
6. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Buka browser Anda dan akses `http://localhost:8000`.

## 🌐 Auto-Deployment (CI/CD) ke Hostdata
Website ini menggunakan GitHub Actions (`.github/workflows/deploy.yml`) untuk mengirim perubahan kode secara otomatis ke server cPanel setiap kali Anda melakukan `git push` ke branch `main`.

### Catatan Penting Deployment
Agar proses sinkronisasi FTP berjalan super cepat dan tidak terkena *timeout*, file `.env`, folder `vendor`, `node_modules`, dan **beberapa aset statis berat** (seperti ikon dan plugin pihak ketiga di dalam `public/assets/vendors/`) telah diabaikan (di-*exclude*) dari proses upload otomatis GitHub.

**Langkah Wajib di cPanel (Hanya dilakukan 1x saat setup awal):**
1. **Upload Aset Template:** Upload file `vendors_assets.zip` ke root folder website di cPanel Anda (`laundry`), lalu **Extract**.
2. **Konfigurasi Database:** Buat file `.env` secara manual di cPanel dan masukkan detail database *production*.
3. **Install Package Production:** Buka Terminal cPanel, masuk ke folder website Anda, lalu jalankan perintah:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

Setelah 3 langkah manual ini selesai dilakukan, kedepannya Anda cukup melakukan `git commit` & `git push` dan website di internet akan langsung terupdate secara otomatis!
