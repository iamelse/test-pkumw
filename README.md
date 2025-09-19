# Aplikasi Manajemen Pasien - Laravel

Aplikasi Laravel ini terhubung ke API eksternal `https://mockapi.pkuwsb.id` untuk manajemen pasien, termasuk registrasi user, login, CRUD pasien, pencarian, filter, dan detail pasien dinamis.

---

## Environment / Stack
- PHP: 8.2.9
- Node.js: 20.19.4
- MySQL / SQLite: sesuai kebutuhan
- Laravel: menggunakan Laravel terbaru sesuai Composer
- Composer: 2.8.10
- Development environment: Laragon
- **Frontend / UI**
  - TailwindCSS
  - Alpine.js
  - TailAdmin ([https://tailadmin.com/](https://tailadmin.com/))

---

## Cara Instalasi
1. **Clone repository**
   ```bash
   git clone <url-repository>
   cd <nama-folder-project>
   ```

2. **Install dependencies Composer**
   ```bash
   composer install
   ```

3. **Install dependencies Node.js (untuk frontend / asset)**
   ```bash
   npm install
   ```

4. **Copy file environment**
   ```bash
   cp .env.example .env
   ```

5. **Generate key aplikasi Laravel**
   ```bash
   php artisan key:generate
   ```

6. **Sesuaikan konfigurasi database**  
   Edit `.env` sesuai environment MySQL / SQLite:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```
7. **File .env Tambahan untuk API**  
   Tambahkan konfigurasi berikut di file .env:
   ```env
    API_BASE_URL=https://mockapi.pkuwsb.id
    API_USERNAME=your_api_username
    API_PASSWORD=your_api_password
   ```

8. **Migrasi database**
   ```bash
   php artisan migrate
   ```

9. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di `http://127.0.0.1:8000`

10. **Build asset frontend**
   ```bash
   npm run dev
   ```
   atau untuk mode production:
   ```bash
   npm run build
   ```

---

## Default Username dan Password
   ```
   username/email: master@example.com
   password: password
   ```
   Atau bisa langsung daftar di aplikasi.

## Checklist Fitur

### 1. Registrasi User
- [x] Username/email menggunakan domain `@pkuwsb.id`
- [x] Pastikan email belum terdaftar
- [x] Password memenuhi ketentuan:
  - [x] Mengandung angka
  - [x] Mengandung huruf kapital
  - [x] Mengandung huruf non-kapital
  - [x] Minimal 7 karakter
- [x] Nama Lengkap diisi
- [x] Foto profil dapat diunggah
- [x] Foto default jika tidak upload
- [x] Registrasi gagal jika validasi email/password tidak terpenuhi
- [x] Data user tersimpan di database SQL jika berhasil

### 2. Login
- [x] User bisa login dengan email & password
- [x] Autentikasi aman menggunakan Laravel Auth

### 3. Manajemen Pasien (CRUD) via API
- [x] Tambah pasien (Create)
- [x] Lihat daftar pasien (Read)
- [x] Edit pasien (Update)
- [x] Hapus pasien (Delete)
- [x] Pemanggilan API dilakukan di controller (Http Client Laravel)
- [x] Flash message untuk sukses/gagal operasi CRUD

### 4. Pencarian Pasien
- [x] Bisa mencari pasien berdasarkan:
  - [x] Nomor Rekam Medis (no RM)
  - [x] Nama Pasien
- [x] Pencarian dilakukan di sisi controller/API

### 5. Filter Pasien
- [x] Bisa filter pasien berdasarkan:
  - [x] Gender
  - [x] Blood Type
- [x] Filter dilakukan di sisi server menggunakan data dari API

### 6. Detail Pasien Dinamis
- [x] Detail pasien ditampilkan tanpa refresh halaman
- [x] Menggunakan **Alpine.js** untuk AJAX
- [x] API dipanggil dari controller, bukan view

---

## Checklist Teknis
- [x] Validasi user menggunakan Laravel Request Validation
- [x] HTTP Client Laravel (`Http::get()`, `post()`, `put()`, `delete()`)
- [x] Flash message menggunakan `session()->flash()`
- [x] Password disimpan menggunakan hashing (`bcrypt`)
- [x] Autentikasi menggunakan Laravel Auth
- [x] AJAX dinamis menggunakan **Alpine.js** untuk detail pasien
- [x] UI / styling menggunakan **TailwindCSS** dan **TailAdmin**

---

## Referensi
- API Eksternal: [https://mockapi.pkuwsb.id](https://mockapi.pkuwsb.id)
- Laravel Documentation: [https://laravel.com/docs](https://laravel.com/docs)
- Alpine.js Documentation: [https://alpinejs.dev](https://alpinejs.dev)
- TailAdmin: [https://tailadmin.com/](https://tailadmin.com/)