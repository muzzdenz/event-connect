# ⚡ Quick Fix - API Configuration

## 🔍 Masalah

Error menunjukkan backend API mencoba connect ke port yang salah atau tidak dapat diakses.

## ✅ Solusi Cepat (5 Menit)

### Langkah 1: Update `.env`

Buka file `.env` di root project dan pastikan ada baris ini:

```env
API_BASE_URL=http://localhost:8000/api
```

**PENTING:** 
- Jika API routes ada di project yang sama → gunakan port 8000 (sama dengan frontend)
- Jika backend API adalah project terpisah → gunakan port berbeda (misalnya 8001)

### Langkah 2: Clear Config

```bash
php artisan config:clear
php artisan cache:clear
```

### Langkah 3: Test API

Buka browser atau gunakan curl:

```bash
# Test apakah API bisa diakses
curl http://localhost:8000/api/events

# Atau buka di browser:
# http://localhost:8000/api/events
```

Jika berhasil, Anda akan melihat JSON response.

### Langkah 4: Restart Server

```bash
# Stop server (Ctrl+C)
# Lalu jalankan lagi
php artisan serve --port=8000
```

## 🎯 Dua Skenario

### Skenario A: API di Project yang Sama (Development)

**File `.env`:**
```env
APP_URL=http://127.0.0.1:8000
API_BASE_URL=http://localhost:8000/api
```

**Jalankan:**
```bash
php artisan serve --port=8000
```

**Akses:**
- Frontend: `http://127.0.0.1:8000`
- API: `http://localhost:8000/api`

### Skenario B: Backend API Terpisah

**File `.env` (Frontend):**
```env
APP_URL=http://127.0.0.1:8000
API_BASE_URL=http://localhost:8001/api
```

**Terminal 1 (Backend API):**
```bash
cd path/to/backend-api
php artisan serve --port=8001
```

**Terminal 2 (Frontend):**
```bash
cd path/to/frontend
php artisan serve --port=8000
```

## ✅ Checklist

- [ ] `API_BASE_URL` sudah di-set di `.env`
- [ ] Sudah menjalankan `php artisan config:clear`
- [ ] Test API berhasil (curl atau browser)
- [ ] Server sudah di-restart

## 🐛 Masih Error?

1. **Cek konfigurasi saat ini:**
   ```bash
   php artisan config:show services.backend
   ```

2. **Cek apakah API benar-benar berjalan:**
   ```bash
   curl http://localhost:8000/api/events
   ```

3. **Cek log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Pastikan tidak ada firewall yang memblokir**

## 📝 Catatan

- Default config sekarang: `http://localhost:8000/api` (API di project yang sama)
- Jika backend API terpisah, ubah ke port yang sesuai di `.env`
- Selalu clear config cache setelah mengubah `.env`



