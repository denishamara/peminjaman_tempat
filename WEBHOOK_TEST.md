# Webhook Testing & Troubleshooting Guide

## 1. Cek Permission di VPS

```bash
# SSH ke VPS
ssh denishaamara@denishaamara.my.id

# Cek permission webhook.php
ls -la /var/www/peminjaman_tempat/public/webhook.php

# Seharusnya:
# -rw-r--r-- (644) - file bisa dibaca oleh web server

# Cek permission deploy.sh
ls -la /var/www/peminjaman_tempat/deploy.sh

# Seharusnya:
# -rwxr-xr-x (755) - file executable

# Jika permission salah, perbaiki:
cd /var/www/peminjaman_tempat
chmod 644 public/webhook.php
chmod +x deploy.sh
chmod 755 deploy.sh
```

## 2. Cek Ownership

```bash
# Cek ownership file
ls -la /var/www/peminjaman_tempat/public/webhook.php
ls -la /var/www/peminjaman_tempat/deploy.sh

# Seharusnya owner: denishaamara atau www-data
# Jika salah:
sudo chown denishaamara:denishaamara /var/www/peminjaman_tempat/public/webhook.php
sudo chown denishaamara:denishaamara /var/www/peminjaman_tempat/deploy.sh
```

## 3. Cek Log Directory Permission

```bash
# Pastikan writable/logs bisa ditulis
ls -la /var/www/peminjaman_tempat/writable/
ls -la /var/www/peminjaman_tempat/writable/logs/

# Jika permission salah:
sudo chown -R www-data:www-data /var/www/peminjaman_tempat/writable/
sudo chmod -R 775 /var/www/peminjaman_tempat/writable/
```

## 4. Test Webhook Langsung di VPS

```bash
# Test 1: Cek apakah webhook.php bisa diakses
curl -I https://denishaamara.my.id/webhook.php

# Seharusnya return: HTTP/1.1 200 OK atau 403 (karena belum ada signature)

# Test 2: Test dengan payload sederhana (akan gagal signature, tapi kita cek error)
curl -X POST https://denishaamara.my.id/webhook.php \
  -H "Content-Type: application/json" \
  -H "X-Hub-Signature-256: sha256=invalid" \
  -d '{"ref":"refs/heads/main"}'

# Seharusnya return: {"status":"error","message":"Invalid signature"}

# Test 3: Cek log
tail -f /var/www/peminjaman_tempat/writable/logs/webhook.log
```

## 5. Generate Signature yang Benar (di VPS)

```bash
# Ganti SECRET_TOKEN dengan token yang sama di webhook.php
SECRET_TOKEN="your_secret_token_here_ganti_dengan_random_string"
PAYLOAD='{"ref":"refs/heads/main"}'

# Generate signature
SIGNATURE=$(echo -n "$PAYLOAD" | openssl dgst -sha256 -hmac "$SECRET_TOKEN" | sed 's/^.* //')
echo "sha256=$SIGNATURE"

# Test dengan signature yang benar
curl -X POST https://denishaamara.my.id/webhook.php \
  -H "Content-Type: application/json" \
  -H "X-Hub-Signature-256: sha256=$SIGNATURE" \
  -d "$PAYLOAD"
```

## 6. Cek Deploy Script Bisa Jalan

```bash
# Test jalankan deploy.sh manual
cd /var/www/peminjaman_tempat
bash deploy.sh

# Jika ada error permission pada git pull:
git config --global --add safe.directory /var/www/peminjaman_tempat

# Jika ada error pada systemctl (perlu sudo):
# Edit file /etc/sudoers.d/webhook
sudo visudo -f /etc/sudoers.d/webhook

# Tambahkan (sesuaikan dengan user):
www-data ALL=(ALL) NOPASSWD: /usr/bin/systemctl restart php8.2-fpm
www-data ALL=(ALL) NOPASSWD: /usr/bin/systemctl restart nginx
denishaamara ALL=(ALL) NOPASSWD: /usr/bin/systemctl restart php8.2-fpm
denishaamara ALL=(ALL) NOPASSWD: /usr/bin/systemctl restart nginx
```

## 7. Cek Nginx/PHP-FPM Error Log

```bash
# Cek error log nginx
sudo tail -f /var/log/nginx/error.log

# Cek error log PHP-FPM
sudo tail -f /var/log/php8.2-fpm.log
# atau
sudo tail -f /var/log/php-fpm/error.log
```

## 8. Test dari Local (Windows PowerShell)

```powershell
# Buat script PowerShell untuk test
$uri = "https://denishaamara.my.id/webhook.php"
$payload = '{"ref":"refs/heads/main"}'

# Signature harus sama dengan yang di webhook.php (SECRET_TOKEN)
$signature = "sha256=PASTE_RESULT_FROM_VPS_HERE"

$headers = @{
    "Content-Type" = "application/json"
    "X-Hub-Signature-256" = $signature
}

try {
    $response = Invoke-WebRequest -Uri $uri -Method POST -Headers $headers -Body $payload
    Write-Host "Status: $($response.StatusCode)"
    Write-Host "Response: $($response.Content)"
} catch {
    Write-Host "Error: $($_.Exception.Message)"
    Write-Host "Status: $($_.Exception.Response.StatusCode.value__)"
}
```

## 9. Troubleshooting Checklist

- [ ] webhook.php permission: 644
- [ ] deploy.sh permission: 755 (executable)
- [ ] writable/logs/ permission: 775
- [ ] Owner: www-data atau denishaamara
- [ ] SECRET_TOKEN sudah diganti (tidak menggunakan default)
- [ ] SECRET_TOKEN di webhook.php sama dengan di GitHub webhook settings
- [ ] deploy.sh bisa jalan manual
- [ ] Git pull tidak ada error
- [ ] Sudoers sudah dikonfigurasi untuk systemctl restart
- [ ] Webhook log menunjukkan request masuk

## 10. Cek Status Terakhir di GitHub

1. Buka: https://github.com/denishamara/peminjaman_tempat/settings/hooks
2. Klik webhook yang sudah dibuat
3. Klik tab "Recent Deliveries"
4. Lihat response dari webhook

**Response yang benar:**
```json
{"status":"success","message":"Deployment completed","output":[...]}
```

**Response error permission:**
```json
{"status":"error","message":"Deployment failed","return_code":126}
```

**Response error signature:**
```json
{"status":"error","message":"Invalid signature"}
```
