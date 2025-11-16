# 🚀 GitHub Webhook Auto Deploy Setup Guide

## Apa itu Webhook?
Webhook ini akan **otomatis deploy** perubahan code dari local ke VPS setiap kali kamu push ke GitHub.

---

## 📋 Setup Langkah-Langkah

### 1️⃣ Generate Secret Token

Buat secret token random untuk keamanan:

```bash
# Di VPS atau local, jalankan:
openssl rand -hex 32
```

Copy token yang dihasilkan (contoh: `a1b2c3d4e5f6...`)

---

### 2️⃣ Upload File ke VPS

**Di Windows (PowerShell):**

```powershell
cd c:\xampp\htdocs\peminjaman_tempat
git add public/webhook.php deploy.sh
git commit -m "Add: GitHub webhook auto deploy"
git push origin main
```

**Di VPS (SSH):**

```bash
cd /var/www/peminjaman_tempat
git pull origin main

# Set executable permission untuk deploy script
chmod +x deploy.sh

# Edit webhook.php untuk ganti secret token
nano public/webhook.php
# Cari line: define('SECRET_TOKEN', 'your_secret_token_here...');
# Ganti dengan token yang kamu generate tadi
# Save: Ctrl+X, Y, Enter
```

---

### 3️⃣ Set Permissions & Sudo Access

```bash
# Berikan permission ke www-data untuk restart services
sudo visudo

# Tambahkan di akhir file:
www-data ALL=(ALL) NOPASSWD: /bin/systemctl restart php8.2-fpm
www-data ALL=(ALL) NOPASSWD: /bin/systemctl restart php8.1-fpm
www-data ALL=(ALL) NOPASSWD: /bin/systemctl restart php8.3-fpm
www-data ALL=(ALL) NOPASSWD: /bin/systemctl restart nginx
www-data ALL=(ALL) NOPASSWD: /bin/systemctl restart mysql
www-data ALL=(ALL) NOPASSWD: /bin/chown -R www-data\:www-data *
www-data ALL=(ALL) NOPASSWD: /bin/chmod -R 775 *

# Save: Ctrl+X, Y, Enter
```

Atau edit deploy.sh untuk menggunakan sudo:

```bash
nano /var/www/peminjaman_tempat/deploy.sh

# Tambahkan 'sudo' di depan systemctl, chown, chmod
# Contoh:
# sudo systemctl restart php8.2-fpm
# sudo chown -R www-data:www-data writable/
```

---

### 4️⃣ Test Webhook Script Manual

```bash
# Test deploy script
cd /var/www/peminjaman_tempat
bash deploy.sh

# Jika berhasil, lanjut ke GitHub
```

---

### 5️⃣ Setup GitHub Webhook

1. Buka repository GitHub: https://github.com/denishamara/peminjaman_tempat
2. Klik **Settings** → **Webhooks** → **Add webhook**
3. Isi form:
   - **Payload URL:** `https://denishaamara.my.id/webhook.php`
   - **Content type:** `application/json`
   - **Secret:** paste token yang kamu generate di step 1
   - **Which events:** pilih **Just the push event**
   - **Active:** ✅ centang
4. Klik **Add webhook**

---

### 6️⃣ Test Webhook

**Di local (Windows):**

```powershell
cd c:\xampp\htdocs\peminjaman_tempat

# Buat perubahan kecil
echo "# Test webhook" >> README.md

# Commit & push
git add .
git commit -m "Test: webhook auto deploy"
git push origin main
```

**Cek di GitHub:**
- Settings → Webhooks → klik webhook yang baru dibuat
- Lihat **Recent Deliveries** → klik delivery terakhir
- Cek **Response** → harus ada status `success`

**Cek di VPS:**

```bash
# Lihat log webhook
tail -f /var/www/peminjaman_tempat/writable/logs/webhook.log

# Atau cek log Nginx
tail -f /var/log/nginx/access.log | grep webhook
```

---

## 🔧 Troubleshooting

### Webhook return 403 Forbidden
- Secret token salah → cek SECRET_TOKEN di `public/webhook.php`
- Signature tidak match → regenerate token dan update di GitHub

### Webhook return 500 Error
- Deploy script tidak ditemukan → cek `chmod +x deploy.sh`
- Permission denied → cek sudo access untuk www-data

### Git pull failed
```bash
# Set git config untuk auto-resolve conflicts
cd /var/www/peminjaman_tempat
git config pull.rebase false
```

### PHP-FPM/Nginx restart failed
```bash
# Tambahkan sudo di deploy.sh atau setup sudoers seperti di step 3
```

---

## 📊 Monitoring

### Cek Log Webhook Real-time:
```bash
tail -f /var/www/peminjaman_tempat/writable/logs/webhook.log
```

### Cek Status Last Deploy:
```bash
cat /var/www/peminjaman_tempat/writable/logs/webhook.log | tail -20
```

### Test Webhook Manual (via curl):
```bash
curl -X POST https://denishaamara.my.id/webhook.php \
  -H "Content-Type: application/json" \
  -H "X-Hub-Signature-256: sha256=$(echo -n '{}' | openssl dgst -sha256 -hmac 'YOUR_SECRET_TOKEN' | cut -d' ' -f2)" \
  -d '{"ref":"refs/heads/main"}'
```

---

## 🎯 Workflow Setelah Setup

1. Edit code di local (Windows)
2. Commit & push ke GitHub
3. GitHub trigger webhook otomatis
4. VPS otomatis:
   - Pull perubahan terbaru
   - Clear cache
   - Restart PHP-FPM & Nginx
5. Website langsung update! ✅

---

## 🔐 Security Tips

1. **Jangan** commit file `.env` (sudah ada di `.gitignore`)
2. **Ganti** SECRET_TOKEN secara berkala
3. **Limit** webhook hanya dari IP GitHub
4. **Monitor** log webhook secara regular

---

## 📝 Optional Features

### Auto Run Migrations
Uncomment di `deploy.sh` line:
```bash
# php spark migrate
```

### Auto Composer Install
Uncomment di `deploy.sh` line:
```bash
# composer install --no-dev --optimize-autoloader
```

### Notifikasi Telegram/Discord
Tambahkan curl request ke deploy.sh untuk kirim notif setelah deploy sukses.

---

**Selamat! Auto-deploy sudah siap digunakan! 🚀**
