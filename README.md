# 📦 Sistem Inventaris Barang IT

Sistem manajemen inventaris aset dan perangkat IT berbasis web, dibangun dengan **Laravel 12**, **Bootstrap 5**, dan **MySQL**.

## 🌐 Demo

**URL:** [https://riostore.id](https://riostore.id)

**Login Admin:**
- Email: `admin@inventaris.com`
- Password: `admin123`

---

## ✨ Fitur

### 🔐 Autentikasi
- Login dengan email & password
- Verifikasi OTP via email (opsional, bisa diaktifkan di pengaturan)
- Logout aman dengan pencatatan aktivitas

### 📊 Dashboard
- 8 widget statistik (total barang, jumlah, tersedia, rusak, digunakan, dipinjam, kategori, tanggal)
- Carousel informasi ringkasan inventaris

### 📦 Manajemen Barang
- CRUD lengkap data barang IT
- Upload foto barang (drag & drop + preview)
- Upload dokumen pendukung (PDF, Word, Excel)
- Filter berdasarkan status dan kondisi
- Autocomplete kategori dan penanggung jawab
- Waktu input otomatis (WIB)
- Validasi form sebelum submit dengan toast notification

### 📤 Barang Keluar
- Pencatatan pengeluaran barang
- Stok otomatis berkurang saat data disimpan
- Stok otomatis kembali saat data dihapus
- Upload foto bukti pengeluaran (wajib)
- Filter berdasarkan tanggal dan pencarian

### 🏷️ Kategori
- CRUD kategori barang
- Modal konfirmasi hapus
- Notifikasi toast sukses/gagal

### 🛡️ Log Aktivitas Admin
- Rekam semua aktivitas login dan logout
- Informasi: username, email, IP address, device, status, level risiko
- Filter berdasarkan status dan level
- Data tidak bisa dihapus (read-only)

### 🌐 Frontend Publik
- Halaman landing page sistem inventaris
- Navbar transparan yang berubah saat scroll
- Statistik real-time dari database
- Carousel informasi
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
# Clone repository
git clone https://github.com/rioichitv/inventarisbarangwithsmtp.git
cd inventarisbarangwithsmtp

# Install dependencies
composer install

# Copy environment
cp .env.example .env

# Generate key
php artisan key:generate

# Konfigurasi database di .env
DB_DATABASE=inventaris
DB_USERNAME=root
DB_PASSWORD=

# Migrasi dan seeder
php artisan migrate --seed

# Storage link
php artisan storage:link

# Jalankan server
php artisan serve
```

Akses di: **http://localhost:8000**

---

## 📧 Konfigurasi Email OTP

Edit `.env` untuk mengaktifkan pengiriman OTP:

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

## 🚀 Deploy ke Hosting (Shared Hosting / Hostinger)

1. Upload semua file ke `public_html`
2. Buat `.htaccess` di root `public_html`:
   ```apacheconf
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   ```
3. Set permission folder `storage` dan `bootstrap/cache` ke **755**
4. Jalankan via Terminal:
   ```bash
   php artisan config:clear
   php artisan migrate --force
   php artisan db:seed --force
   ```

---

## 📁 Struktur Folder Utama

```
├── app/
│   ├── Http/Controllers/    # AuthController, BarangController, dll
│   ├── Models/              # Barang, BarangKeluar, ActivityLog, Setting
│   └── Mail/                # SendOtpMail
├── database/
│   ├── migrations/          # Semua migrasi tabel
│   └── seeders/             # Data awal (admin + contoh barang)
├── resources/views/
│   ├── auth/                # login.blade.php, otp.blade.php
│   ├── barang/              # CRUD barang
│   ├── barang-keluar/       # CRUD barang keluar
│   ├── dashboard.blade.php
│   ├── frontend/            # Landing page publik
│   └── layouts/app.blade.php
└── routes/web.php
```

---

## 👨‍💻 Developer

**Rio Pratama Putra**

---

## 📄 Lisensi

Project ini dibuat untuk keperluan sistem inventaris internal.
