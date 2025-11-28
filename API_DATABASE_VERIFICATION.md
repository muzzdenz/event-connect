# Verifikasi: API Menggunakan Database

## ✅ Konfirmasi: API Sudah Menggunakan Database

### 1. Endpoint API Login

**Route:** `POST /api/auth/login`  
**Controller:** `App\Http\Controllers\Api\AuthController@login`  
**File:** `app/Http/Controllers/Api/AuthController.php` (baris 61-95)

### 2. Kode API Login Menggunakan Database

```php
public function login(Request $request): JsonResponse
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // ✅ MENGGUNAKAN DATABASE: Auth::attempt() membaca dari database
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    // ✅ MENGGUNAKAN DATABASE: Query user dari database
    $user = User::where('email', $request->email)->firstOrFail();
    
    // ✅ MENGGUNAKAN DATABASE: Token disimpan di database (personal_access_tokens)
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful',
        'data' => [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]
    ]);
}
```

### 3. Bukti Menggunakan Database

#### A. `Auth::attempt()` 
- Fungsi ini membaca dari tabel `users` di database
- Membandingkan email dan password dengan hash di database
- **TIDAK menggunakan data hardcoded/lokal**

#### B. `User::where('email', $request->email)->firstOrFail()`
- Query langsung ke database tabel `users`
- Menggunakan Eloquent ORM yang terhubung ke database

#### C. `$user->createToken('auth_token')`
- Token disimpan di tabel `personal_access_tokens` di database
- Bukan data in-memory atau hardcoded

### 4. Verifikasi Route

Jalankan command berikut untuk melihat route yang terdaftar:

```bash
php artisan route:list --path=api/auth
```

**Output:**
```
POST   api/auth/login ................ Api\AuthController@login
```

### 5. Konfigurasi Database

API menggunakan konfigurasi database yang sama dengan aplikasi web:
- **File:** `.env`
- **Konfigurasi:** `config/database.php`
- **Connection:** Default connection (MySQL/MariaDB)

### 6. Test API Login Menggunakan Database

#### Test dengan curl:
```bash
curl -X POST "http://localhost:8000/api/auth/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password123"
  }'
```

#### Test dengan Browser Console:
```javascript
fetch('/api/auth/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        email: 'user@example.com',
        password: 'password123'
    })
})
.then(res => res.json())
.then(data => console.log('Response:', data));
```

### 7. Tabel Database yang Digunakan

1. **`users`** - Menyimpan data user (email, password hash, dll)
2. **`personal_access_tokens`** - Menyimpan token API untuk autentikasi

### 8. Kesimpulan

✅ **API sudah menggunakan database**  
✅ **Tidak ada data hardcoded atau lokal**  
✅ **Menggunakan database yang sama dengan aplikasi web**  
✅ **Auth::attempt() membaca dari tabel users di database**

### 9. Perbedaan dengan Data Lokal

| Aspek | Data Lokal (Lama) | API dengan Database (Sekarang) |
|-------|------------------|--------------------------------|
| Sumber Data | Hardcoded/Array | Database MySQL |
| Validasi | If-else manual | Auth::attempt() dari database |
| Token | Tidak ada | Disimpan di database |
| User Data | Array statis | Query dari tabel users |

### 10. Troubleshooting

Jika masih ada masalah, cek:

1. **Database Connection:**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

2. **User ada di database:**
   ```bash
   php artisan tinker
   >>> User::where('email', 'test@example.com')->first();
   ```

3. **Route terdaftar:**
   ```bash
   php artisan route:list --path=api/auth/login
   ```

4. **Clear cache:**
   ```bash
   php artisan route:clear
   php artisan config:clear
   php artisan cache:clear
   ```

---

**Status:** ✅ **API Sudah Menggunakan Database**  
**Tanggal Verifikasi:** 2025-01-XX  
**Versi Laravel:** 12.33.0








