# 📦 Sistem Inventaris Barang IT

Sistem manajemen inventaris aset dan perangkat IT berbasis web, dibangun dengan **Laravel 12**, **Bootstrap 5**, dan **MySQL**.

## 🌐 Demo

**URL:** [https://riostore.id](https://riostore.id)

---

## 📸 Screenshot

### Dashboard
![Dashboard](docs/dashboard.png)

> Tampilan dashboard dengan 8 widget statistik dan carousel informasi

---

## ✨ Fitur

### 🔐 Autentikasi
- Login dengan email & password
- Verifikasi **OTP via email** (opsional, bisa diaktifkan di Web Config)
- Logout aman dengan pencatatan aktivitas otomatis

### 📊 Dashboard
- 8 widget statistik real-time (total barang, jumlah, tersedia, rusak, digunakan, dipinjam, kategori, tanggal)
- Carousel informasi ringkasan inventaris (3 slide otomatis)

### 📦 Manajemen Barang (CRUD)
- Tambah, edit, detail, dan hapus data barang IT
- Upload **foto barang** (drag & drop + preview, wajib diisi)
- Upload **dokumen pendukung** (PDF, Word, Excel, opsional)
- Filter berdasarkan status dan kondisi
- **Autocomplete** kategori dan penanggung jawab
- Waktu input **otomatis** (WIB)
- Validasi form client-side dengan **toast notification**
- Modal konfirmasi hapus yang cantik

### 📤 Barang Keluar (CRUD)
- Pencatatan pengeluaran barang dengan data penerima lengkap
- Stok **otomatis berkurang** saat data disimpan
- Stok **otomatis kembali** saat data dihapus
- Upload **foto bukti pengeluaran** (wajib)
- Autocomplete bagian/divisi dan petugas
- Filter berdasarkan tanggal dan pencarian

### 🏷️ Kategori
- CRUD kategori barang IT
- Modal konfirmasi hapus
- Toast notification sukses/gagal

### 🛡️ Log Aktivitas Admin
- Rekam semua aktivitas login dan logout
- Data: username, email, IP address, device, status, level risiko
- Level risiko: **Low** (hijau), **Medium** (orange), **Berisiko** (merah)
- Filter berdasarkan status dan level
- Data **read-only** — tidak bisa dihapus

### ⚙️ Web Config
- Aktifkan/nonaktifkan OTP login
- Konfigurasi sistem melalui antarmuka

### 🌐 Frontend Publik
- Landing page sistem inventaris DPR RI
- Navbar **transparan** yang berubah saat scroll
- Statistik real-time dari database
- 6 kartu fitur unggulan
- Tombol masuk ke sistem

---

## 🛠️ Teknologi

| Teknologi | Versi |
|-----------|-------|
| PHP | ^8.2 |
| Laravel | ^12.0 |
| Bootstrap | 5.3.3 |
| Bootstrap Icons | 1.11.3 |
| MySQL | 5.7+ |
| jQuery | 3.7.1 |
| jQuery UI | 1.13.2 |

---

## ⚙️ Instalasi Lokal

```bash
# 1. Clone repository
git clone https://github.com/rioichitv/inventarisbarangwithsmtp.git
cd inventarisbarangwithsmtp

# 2. Install dependencies
composer install

# 3. Copy & konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Atur database di .env
DB_DATABASE=inventaris
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrasi dan seeder
php artisan migrate --force
php artisan db:seed --force

# 6. Storage link
php artisan storage:link

# 7. Jalankan server
php artisan serve
```

Akses: **http://localhost:8000**

Login: `admin@inventaris.com` / `admin123`

---

## 📧 Konfigurasi SMTP (OTP Email)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD=app_password_gmail
MAIL_FROM_ADDRESS=emailanda@gmail.com
MAIL_FROM_NAME="Inventaris IT"
```

---

## 🚀 Deploy ke Shared Hosting (Hostinger)

1. Upload semua file ke `public_html`
2. Buat `.htaccess` baru di root `public_html`:
   ```apacheconf
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   ```
3. Set permission `storage/` dan `bootstrap/cache/` → **755**
4. Jalankan via Terminal Hostinger:
   ```bash
   php artisan config:clear
   php artisan migrate --force
   php artisan db:seed --force
   ```

---

## 📁 Struktur Utama

```
├── app/Http/Controllers/    → AuthController, BarangController, dll
├── app/Models/              → Barang, BarangKeluar, ActivityLog, Setting
├── app/Mail/                → SendOtpMail
├── database/migrations/     → Semua migrasi tabel
├── database/seeders/        → Data awal admin + contoh barang
├── resources/views/
│   ├── auth/                → login, otp
│   ├── barang/              → CRUD barang
│   ├── barang-keluar/       → CRUD barang keluar
│   ├── frontend/            → Landing page publik
│   ├── layouts/app.blade.php
│   └── dashboard.blade.php
└── routes/web.php
```

---

## 👨‍💻 Developer

**Rio Pratama Putra** 
