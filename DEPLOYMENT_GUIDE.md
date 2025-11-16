# 🚀 Deployment Guide - Fix Error 500 Dashboard

## Files yang Harus Di-Upload ke VPS

Berikut 3 file yang sudah diperbaiki dan **HARUS** di-upload ke VPS Anda:

### 1. `app/Models/UserModel.php`
**Path di VPS:** `/var/www/peminjaman_tempat/app/Models/UserModel.php`

**Perbaikan:** Mengganti fungsi MySQL `total_booking_user()` yang tidak ada dengan query COUNT langsung.

### 2. `app/Controllers/Dashboard.php`
**Path di VPS:** `/var/www/peminjaman_tempat/app/Controllers/Dashboard.php`

**Perbaikan:** Memperbaiki query GROUP BY di line 57 (menambahkan `MIN(tanggal_mulai) AS min_tanggal`).

### 3. `app/Database/Migrations/2025-11-15-125656_CreateLogBookingTable.php`
**Path di VPS:** `/var/www/peminjaman_tempat/app/Database/Migrations/2025-11-15-125656_CreateLogBookingTable.php`

**Perbaikan:** Memperbaiki default value untuk kolom `waktu_log` menggunakan raw SQL ALTER.

---

## Cara Upload ke VPS

### Opsi 1: Via Git (Recommended)
```bash
# Di local Windows (PowerShell/Git Bash)
cd c:\xampp\htdocs\peminjaman_tempat
git add .
git commit -m "Fix: GROUP BY errors and missing MySQL function"
git push origin main

# Di VPS Linux (SSH)
cd /var/www/peminjaman_tempat
git pull origin main
```

### Opsi 2: Via SCP/SFTP (FileZilla, WinSCP)
Upload 3 file di atas ke path yang sesuai di VPS.

### Opsi 3: Via SSH Copy-Paste Manual
```bash
# Login SSH ke VPS
ssh denishaamara@denishaamara.my.id

# Edit file satu per satu
nano /var/www/peminjaman_tempat/app/Models/UserModel.php
# Paste konten dari local, Ctrl+X, Y, Enter

nano /var/www/peminjaman_tempat/app/Controllers/Dashboard.php
# Paste konten dari local, Ctrl+X, Y, Enter

nano /var/www/peminjaman_tempat/app/Database/Migrations/2025-11-15-125656_CreateLogBookingTable.php
# Paste konten dari local, Ctrl+X, Y, Enter
```

---

## Setelah Upload, Jalankan di VPS:

```bash
# 1. Masuk ke direktori project
cd /var/www/peminjaman_tempat

# 2. Jalankan migration (jika belum)
php spark migrate

# 3. Jalankan seeder (jika belum ada user)
php spark db:seed UsersSeeder

# 4. Clear cache (optional tapi recommended)
rm -rf writable/cache/*
rm -rf writable/debugbar/*

# 5. Set permission (jika perlu)
sudo chown -R www-data:www-data writable/
sudo chmod -R 775 writable/
```

---

## Verifikasi

1. Buka browser: https://denishaamara.my.id/dashboard
2. Error 500 seharusnya hilang
3. Dashboard tampil dengan grafik statistik

---

## Troubleshooting

### Jika masih error 500:
```bash
# Cek log error terbaru
tail -f /var/www/peminjaman_tempat/writable/logs/log-$(date +%Y-%m-%d).log
```

### Jika error "SQLSTATE GROUP BY":
Pastikan 3 file di atas sudah benar-benar ter-upload dan tidak tertimpa versi lama.

### Jika error "Class not found":
```bash
composer dump-autoload
```

---

## Credentials untuk Testing

Setelah seeder berhasil dijalankan, gunakan credential berikut:

- **Administrator:** admin / Admin123!
- **Petugas:** petugas1 / Petugas123!
- **Peminjam:** peminjam1 / Peminjam123!

---

**Catatan:** Error Cloudflare dan ERR_BLOCKED_BY_CLIENT adalah error browser extension (ad blocker), bukan dari server. Abaikan saja atau disable ad blocker untuk domain Anda.
