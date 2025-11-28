# 🔧 Quick Fix: Backend API Configuration

## Masalah
Error menunjukkan backend API mencoba connect ke `http://localhost:8000/api` padahal frontend juga berjalan di port 8000.

## Solusi Cepat

### 1. Buka file `.env` di root project
Cari baris `API_BASE_URL` atau tambahkan jika belum ada:

```env
API_BASE_URL=http://localhost:8001/api
```

**PENTING:** Pastikan port berbeda dari frontend!
- Frontend: port 8000
- Backend API: port 8001 (atau port lain)

### 2. Clear config cache
Jalankan di terminal/command prompt:

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Pastikan Backend API Berjalan
Di terminal terpisah, jalankan backend API:

```bash
# Jika backend API adalah Laravel project terpisah
cd path/to/backend-api
php artisan serve --port=8001

# Atau jika backend API sudah berjalan di server lain
# Pastikan bisa diakses di http://localhost:8001/api
```

### 4. Test Koneksi
Buka browser atau gunakan curl:

```bash
# Test apakah backend API bisa diakses
curl http://localhost:8001/api/events

# Atau buka di browser:
# http://localhost:8001/api/events
```

Jika berhasil, Anda akan melihat JSON response.

### 5. Restart Frontend Server
Setelah mengubah `.env`, restart frontend:

```bash
# Stop server (Ctrl+C)
# Lalu jalankan lagi
php artisan serve --port=8000
```

## Checklist

- [ ] `API_BASE_URL` di `.env` sudah di-set ke port yang berbeda (misalnya 8001)
- [ ] Sudah menjalankan `php artisan config:clear`
- [ ] Backend API server sedang berjalan di port yang benar
- [ ] Frontend server sudah di-restart setelah perubahan `.env`

## Jika Masih Error

1. **Cek apakah backend API benar-benar berjalan:**
   ```bash
   # Test dengan curl
   curl http://localhost:8001/api/events
   ```

2. **Cek log Laravel:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Pastikan tidak ada firewall yang memblokir:**
   - Windows Firewall
   - Antivirus
   - Network settings

4. **Cek apakah port sudah digunakan:**
   ```bash
   # Windows (PowerShell)
   netstat -ano | findstr :8001
   
   # Linux/Mac
   lsof -i :8001
   ```

## Contoh Konfigurasi yang Benar

**File `.env`:**
```env
APP_URL=http://127.0.0.1:8000
API_BASE_URL=http://localhost:8001/api
API_TIMEOUT=10
```

**Terminal 1 (Backend API):**
```bash
php artisan serve --port=8001
# Output: Server running on http://localhost:8001
```

**Terminal 2 (Frontend):**
```bash
php artisan serve --port=8000
# Output: Server running on http://127.0.0.1:8000
```



