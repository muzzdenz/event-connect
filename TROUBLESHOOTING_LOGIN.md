# Troubleshooting Login dengan API

## Masalah: Tidak bisa login setelah menggunakan API

### Langkah Debugging:

1. **Buka Browser Console (F12)**
   - Buka halaman login
   - Tekan F12 untuk membuka Developer Tools
   - Lihat tab Console untuk melihat error messages

2. **Cek Network Tab**
   - Buka tab Network di Developer Tools
   - Coba login
   - Lihat request ke `/api/auth/login`
   - Cek status code dan response

3. **Kemungkinan Masalah:**

   #### A. API Endpoint Tidak Dapat Diakses
   - **Error**: `Failed to fetch` atau `Network Error`
   - **Solusi**: 
     - Pastikan server Laravel berjalan
     - Cek apakah `/api/auth/login` bisa diakses langsung
     - Test dengan curl: `curl -X POST http://localhost:8000/api/auth/login -H "Content-Type: application/json" -d '{"email":"test@example.com","password":"password"}'`

   #### B. CSRF Token Error
   - **Error**: `419` atau `CSRF token mismatch`
   - **Solusi**: 
     - Pastikan meta tag CSRF sudah ada di head
     - Clear browser cache dan cookies
     - Coba refresh halaman

   #### C. Response Format Tidak Sesuai
   - **Error**: `Token tidak ditemukan dalam response`
   - **Solusi**:
     - Cek response di Network tab
     - Pastikan response memiliki struktur: `{ "success": true, "data": { "token": "...", "user": {...} } }`

   #### D. Session Creation Failed
   - **Error**: `Gagal membuat session`
   - **Solusi**:
     - Cek apakah route `/auth/create-session` bisa diakses
     - Pastikan CSRF token dikirim dengan benar
     - Cek browser console untuk error detail

4. **Test Manual dengan Browser Console:**

   ```javascript
   // Test API Login
   fetch('/api/auth/login', {
       method: 'POST',
       headers: {
           'Content-Type': 'application/json',
           'Accept': 'application/json'
       },
       body: JSON.stringify({
           email: 'your-email@example.com',
           password: 'your-password'
       })
   })
   .then(res => res.json())
   .then(data => console.log('Login Response:', data))
   .catch(error => console.error('Error:', error));
   ```

5. **Cek Log Laravel:**
   - Buka `storage/logs/laravel.log`
   - Lihat error yang terjadi saat login

## Checklist Perbaikan:

- [ ] Server Laravel berjalan
- [ ] Route `/api/auth/login` dapat diakses
- [ ] Route `/auth/create-session` dapat diakses  
- [ ] CSRF token meta tag ada di head
- [ ] Browser console tidak menunjukkan error JavaScript
- [ ] Network tab menunjukkan request berhasil (status 200)
- [ ] Response API memiliki struktur yang benar
- [ ] Token disimpan di localStorage
- [ ] Session berhasil dibuat
- [ ] Redirect ke dashboard berhasil

## Common Issues:

1. **CORS Error**: Jika menggunakan domain berbeda, pastikan CORS dikonfigurasi
2. **Session Driver**: Pastikan session driver di `.env` sudah benar
3. **Token Storage**: Pastikan browser mengizinkan localStorage
4. **Route Cache**: Jalankan `php artisan route:clear` jika route tidak update









