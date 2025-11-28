# Backend API Configuration

## Quick Start

1. **Jalankan Backend API** di port yang berbeda (misalnya port 8001):
   ```bash
   # Di terminal/command prompt terpisah
   php artisan serve --port=8001
   ```

2. **Set API_BASE_URL** di file `.env`:
   ```env
   API_BASE_URL=http://localhost:8001/api
   ```

3. **Clear config cache**:
   ```bash
   php artisan config:clear
   ```

4. **Jalankan Frontend** di port 8000:
   ```bash
   php artisan serve --port=8000
   ```

## Setup Instructions

Aplikasi frontend ini memerlukan backend API yang berjalan terpisah. Ikuti langkah-langkah berikut:

### 1. Konfigurasi Environment

Tambahkan atau update variabel berikut di file `.env`:

```env
# URL backend API (harus berbeda dari frontend)
API_BASE_URL=http://localhost:8001/api

# Optional: URL untuk assets (jika berbeda dari base_url)
# API_ASSET_BASE_URL=http://localhost:8001

# Optional: Timeout untuk request API (dalam detik, default: 10)
# API_TIMEOUT=10
```

### 2. Pastikan Backend API Berjalan

Backend API harus berjalan di port yang berbeda dari frontend:

- **Frontend**: `http://127.0.0.1:8000` atau `http://localhost:8000`
- **Backend API**: `http://localhost:8001/api` (atau port lain sesuai konfigurasi)

### 3. Endpoint yang Diperlukan

Backend API harus menyediakan endpoint berikut:

- `POST /api/auth/login` - Login user
- `POST /api/auth/register` - Register user baru
- `POST /api/auth/logout` - Logout user
- `GET /api/auth/me` - Get user yang sedang login
- `POST /api/auth/forgot-password` - Request reset password
- `POST /api/auth/reset-password` - Reset password
- `GET /api/events` - List events
- `GET /api/events/{id}` - Detail event
- `GET /api/categories` - List categories
- Dan endpoint lainnya sesuai kebutuhan

### 4. Format Response API

Backend API harus mengembalikan response dalam format berikut:

**Success Response:**
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    // Data object
  }
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    // Validation errors (optional)
  }
}
```

### 5. Troubleshooting

**Error: "cURL error 28: Operation timed out"**
- Pastikan backend API server sedang berjalan
- Periksa `API_BASE_URL` di `.env` sudah benar
- Pastikan port backend API berbeda dari frontend
- Cek firewall atau network settings

**Error: "API_BASE_URL cannot point to the same server"**
- Pastikan `API_BASE_URL` tidak mengarah ke server yang sama dengan frontend
- Gunakan port yang berbeda (misalnya: frontend di 8000, backend di 8001)

**Error: "Cannot connect to backend API"**
- Pastikan backend API server sudah di-start
- Test koneksi dengan: `curl http://localhost:8001/api/health` (atau endpoint test lainnya)
- Periksa apakah ada middleware yang memblokir request

### 6. Testing Connection

Setelah konfigurasi, test koneksi dengan:

```bash
# Test dari terminal
curl http://localhost:8001/api/events

# Atau buka di browser
# http://localhost:8001/api/events
```

Jika backend API merespons dengan benar, Anda akan melihat JSON response.

