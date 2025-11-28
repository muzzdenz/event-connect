# 🚀 Setup Guide - Event Connect

## 📋 Dua Skenario Konfigurasi

### Skenario 1: API di Project yang Sama (Recommended untuk Development)

Jika API routes berada di project yang sama (file `routes/api.php`), gunakan konfigurasi ini:

**File `.env`:**
```env
APP_URL=http://127.0.0.1:8000
API_BASE_URL=http://localhost:8000/api
```

**Jalankan server:**
```bash
php artisan serve --port=8000
```

**Akses:**
- Frontend: `http://127.0.0.1:8000`
- API: `http://localhost:8000/api`
- API Docs: `http://127.0.0.1:8000/api-docs`

### Skenario 2: API Terpisah (Production/Staging)

Jika backend API adalah project terpisah atau berjalan di server berbeda:

**File `.env` (Frontend):**
```env
APP_URL=http://127.0.0.1:8000
API_BASE_URL=http://localhost:8001/api
# Atau untuk staging/production:
# API_BASE_URL=https://staging-eventconnect.sre-telkomuniversity-pwt.org/api
```

**Terminal 1 - Backend API:**
```bash
cd path/to/backend-api
php artisan serve --port=8001
```

**Terminal 2 - Frontend:**
```bash
cd path/to/frontend
php artisan serve --port=8000
```

## 🔧 Setup Langkah demi Langkah

### 1. Pilih Skenario

Tentukan apakah Anda menggunakan:
- ✅ **Skenario 1**: API di project yang sama (development)
- ✅ **Skenario 2**: API terpisah (production/staging)

### 2. Konfigurasi `.env`

Buka file `.env` dan set `API_BASE_URL` sesuai skenario yang dipilih.

### 3. Clear Config Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Test Koneksi

**Untuk Skenario 1:**
```bash
curl http://localhost:8000/api/events
```

**Untuk Skenario 2:**
```bash
curl http://localhost:8001/api/events
```

Jika berhasil, Anda akan melihat JSON response.

### 5. Jalankan Server

**Skenario 1 (Single Server):**
```bash
php artisan serve --port=8000
```

**Skenario 2 (Dual Server):**
```bash
# Terminal 1
cd backend-api && php artisan serve --port=8001

# Terminal 2  
cd frontend && php artisan serve --port=8000
```

## ✅ Checklist

- [ ] `API_BASE_URL` sudah di-set di `.env`
- [ ] Sudah menjalankan `php artisan config:clear`
- [ ] Backend API server berjalan (jika Skenario 2)
- [ ] Test koneksi berhasil
- [ ] Frontend server sudah di-start

## 🐛 Troubleshooting

### Error: "Cannot connect to backend API"

1. **Cek apakah backend API berjalan:**
   ```bash
   # Test dengan curl
   curl http://localhost:8000/api/events  # Skenario 1
   curl http://localhost:8001/api/events  # Skenario 2
   ```

2. **Cek konfigurasi:**
   ```bash
   php artisan config:show services.backend
   ```

3. **Cek log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Error: "Maximum execution time exceeded"

- Pastikan backend API benar-benar berjalan
- Periksa `API_TIMEOUT` di `.env` (default: 10 detik)
- Pastikan tidak ada firewall yang memblokir

### Error: "502 Bad Gateway"

- Backend API tidak berjalan atau tidak dapat diakses
- `API_BASE_URL` salah atau tidak sesuai
- Port backend API berbeda dari yang dikonfigurasi

## 📝 Catatan Penting

1. **Development**: Gunakan Skenario 1 untuk development lokal
2. **Production**: Gunakan Skenario 2 dengan URL production/staging
3. **Port**: Pastikan port frontend dan backend berbeda jika menggunakan Skenario 2
4. **Cache**: Selalu clear config cache setelah mengubah `.env`

## 🔗 Link Penting

- API Documentation: `http://127.0.0.1:8000/api-docs`
- Frontend: `http://127.0.0.1:8000`
- API Base: `http://localhost:8000/api` (Skenario 1) atau `http://localhost:8001/api` (Skenario 2)



