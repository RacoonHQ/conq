# Laravel Conq

Aplikasi Laravel modern yang dibangun untuk kolaborasi dan pengembangan tim.

**Repository:** https://github.com/RacoonHQ/conq.git

## Deskripsi Proyek

Laravel Conq adalah aplikasi web framework yang dibangun di atas Laravel 12, dirancang untuk menyediakan fondasi yang kuat dalam mengembangkan aplikasi web yang skalabel dan mudah dipelihara. Proyek ini mencakup:

- **Framework Modern**: Dibangun dengan Laravel 12 dan PHP 8.2+
- **Integrasi AI**: Termasuk layanan AI untuk fitur-fitur cerdas
- **Sistem Percakapan**: Sistem percakapan dan chat yang terintegrasi
- **Manajemen Pengguna**: Sistem autentikasi dan otorisasi pengguna yang lengkap
- **Alat Pengembangan**: Lingkungan pengembangan yang sudah dikonfigurasi dengan hot reload
- **Suite Pengujian**: Pengaturan pengujian komprehensif dengan PHPUnit

### Fitur Utama

- Desain API RESTful
- Migrasi dan seeding database
- Sistem antrian untuk pemrosesan background
- Logging dan monitoring real-time
- Kompilasi aset frontend dengan Vite
- Pemformatan kode dengan Laravel Pint

## Petunjuk Instalasi

### Prasyarat

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js dan npm
- Database (MySQL, PostgreSQL, atau SQLite)

### Instalasi Cepat

1. **Clone repository**
   ```bash
   git clone https://github.com/RacoonHQ/conq.git
   cd laravel-conq
   ```

2. **Jalankan skrip instalasi otomatis**
   ```bash
   composer run setup
   ```
   
   Skrip ini akan:
   - Menginstal dependensi PHP
   - Menyalin file environment
   - Menghasilkan application key
   - Menjalankan migrasi database
   - Menginstal dan membangun aset frontend

3. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Perbarui file `.env` Anda dengan:
   - Kredensial database
   - Konfigurasi email
   - Kredensial layanan lainnya

4. **Mulai server pengembangan**
   ```bash
   composer run dev
   ```
   
   Ini akan menjalankan:
   - Server pengembangan Laravel (http://localhost:8000)
   - Worker antrian
   - Monitoring log
   - Kompilasi aset Vite

### Instalasi Manual

Jika Anda lebih suka instalasi manual:

```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start server
php artisan serve
```

## Panduan Kontribusi Git

### Konvensi Penamaan Branch

- `feature/nama-fitur` - Fitur baru
- `bugfix/deskripsi-bug` - Perbaikan bug
- `hotfix/perbaikan-kritis` - Perbaikan kritis produksi
- `refactor/perbaikan-kode` - Refactoring kode
- `docs/update-dokumentasi` - Pembaruan dokumentasi

### Format Pesan Commit

Ikuti spesifikasi [Conventional Commits](https://www.conventionalcommits.org/):

```
<tipe>[opsional scope]: <deskripsi>

[opsional body]

[opsional footer(s)]
```

Tipe:
- `feat`: Fitur baru
- `fix`: Perbaikan bug
- `docs`: Dokumentasi
- `style`: Perubahan gaya kode
- `refactor`: Refactoring kode
- `test`: Menambah atau memperbarui tes
- `chore`: Tugas pemeliharaan

Contoh:
```
feat(auth): tambahkan autentikasi dua faktor
fix(api): perbaiki error endpoint profil pengguna
docs(readme): perbarui petunjuk instalasi
```

### Proses Pull Request

1. **Buat branch fitur** dari `main`
2. **Lakukan perubahan** mengikuti standar coding
3. **Jalankan tes** untuk memastikan semua berfungsi
4. **Commit perubahan** dengan pesan commit yang benar
5. **Push ke fork** Anda dan buat Pull Request
6. **Tunggu code review** dan tanggapi feedback

### Standar Kualitas Kode

- Ikuti standar coding [PSR-12](https://www.php-fig.org/psr/psr-12/)
- Jalankan `composer run test` sebelum submit
- Gunakan `vendor/bin/pint` untuk pemformatan kode
- Tulis tes untuk fitur baru
- Pertahankan metode kecil dan fokus

## Alur Kerja Pengembangan

### Pengembangan Harian

1. **Mulai lingkungan pengembangan**
   ```bash
   composer run dev
   ```

2. **Lakukan perubahan** pada kode Anda
3. **Jalankan tes** secara berkala
   ```bash
   composer run test
   ```

4. **Format kode**
   ```bash
   vendor/bin/pint
   ```

### Skrip yang Tersedia

- `composer run setup` - Instalasi proyek lengkap
- `composer run dev` - Mulai lingkungan pengembangan
- `composer run test` - Jalankan suite tes
- `npm run dev` - Mulai kompilasi aset
- `npm run build` - Bangun aset produksi

### Manajemen Database

```bash
# Buat migrasi baru
php artisan make:migration create_nama_tabel

# Jalankan migrasi
php artisan migrate

# Rollback migrasi
php artisan migrate:rollback

# Migrasi fresh dengan seeding
php artisan migrate:fresh --seed
```

### Pengujian

```bash
# Jalankan semua tes
php artisan test

# Jalankan tes spesifik
php artisan test --filter NamaTes

# Hasilkan coverage tes
php artisan test --coverage
```

## Cara untuk Tim Kontribusi

### Untuk Tim Developer

#### 1. Persiapan Awal

- **Instal alat yang dibutuhkan**:
  - PHP 8.2+
  - Composer
  - Node.js
  - Git
  - IDE/Editor (VS Code, PhpStorm, dll)

- **Setup repository**:
  ```bash
  git clone https://github.com/RacoonHQ/conq.git
  cd laravel-conq
  composer run setup
  ```

#### 2. Alur Kerja Pengembangan

1. **Ambil tugas dari manajemen proyek** (Jira, Trello, dll)
2. **Buat branch baru**:
   ```bash
   git checkout -b feature/nama-fitur
   ```
3. **Kembangkan sesuai kebutuhan**
4. **Uji secara lokal**:
   ```bash
   composer run test
   ```
5. **Commit dengan format yang benar**:
   ```bash
   git add .
   git commit -m "feat(modul): tambahkan fitur baru"
   ```
6. **Push dan buat Pull Request**

#### 3. Proses Code Review

- **Setiap PR harus di-review** oleh minimal 1 anggota tim
- **Checklist review**:
  - Kode mengikuti standar PSR-12
  - Tes disertakan dan berhasil
  - Dokumentasi diperbarui
  - Tidak ada nilai yang di-hardcode
  - Pertimbangan keamanan ditangani

#### 4. Deployment

- **Development**: Auto-deploy ke server development setiap merge ke `develop`
- **Staging**: Deploy manual ke staging setelah persetujuan
- **Production**: Deploy manual ke production dengan jadwal

### Untuk Tim QA

#### 1. Proses Pengujian

- **Unit Testing**: Tanggung jawab Developer
- **Integration Testing**: Verifikasi tim QA
- **User Acceptance Testing**: Validasi pengguna bisnis

#### 2. Pelaporan Bug

Gunakan format berikut untuk laporan bug:

```
**Judul**: [Tipe Bug] - Deskripsi Singkat
**Lingkungan**: Development/Staging/Production
**Browser**: Chrome/Firefox/Safari
**Langkah-langkah Reproduksi**:
1. Langkah 1
2. Langkah 2
3. Langkah 3
**Hasil yang Diharapkan**: Seharusnya terjadi apa
**Hasil Aktual**: Yang sebenarnya terjadi
**Screenshot**: [Lampirkan jika ada]
```

### Untuk Tim Product/Designer

#### 1. Integrasi Desain

- **File desain** disimpan di folder bersama (Figma, Adobe XD)
- **Pustaka komponen** menggunakan Blade components
- **Framework CSS**: Tailwind CSS

#### 2. Manajemen Konten

- **Konten statis**: Edit di file bahasa (`resources/lang`)
- **Konten dinamis**: Kelola melalui panel admin
- **Gambar**: Upload melalui media manager

### Pedoman Komunikasi

#### 1. Daily Standup

- **Waktu**: Setiap hari pukul 09:00
- **Format**: Kemarin apa yang dikerjakan, Hari ini apa, Ada kendala apa
- **Durasi**: Maksimal 15 menit

#### 2. Sprint Planning

- **Frekuensi**: Setiap 2 minggu
- **Peserta**: Seluruh tim pengembangan
- **Output**: Sprint backlog dengan breakdown tugas

#### 3. Retrospective

- **Frekuensi**: Akhir setiap sprint
- **Fokus**: Peningkatan proses
- **Action items**: Didokumentasikan dan dilacak

### Praktik Terbaik

#### 1. Kualitas Kode

- **Ikuti PSR-12** standar coding
- **Tulis tes** untuk semua fitur baru
- **Gunakan type hints** untuk parameter dan return values
- **Pertahankan metode kecil** dan fokus

#### 2. Keamanan

- **Validasi semua input** data
- **Gunakan prepared statements** untuk query database
- **Implementasikan autentikasi** dan otorisasi yang tepat
- **Pertahankan dependensi terbaru**

#### 3. Performa

- **Gunakan caching** untuk data yang sering diakses
- **Optimalkan query database**
- **Implementasikan lazy loading** untuk relationships
- **Monitor performa aplikasi**

## Dukungan

Untuk pertanyaan atau dukungan:
- Buat issue di repository
- Hubungi tim pengembangan
- Lihat dokumentasi Laravel di [https://laravel.com/docs](https://laravel.com/docs)

## Lisensi

Proyek ini adalah perangkat lunak open-source berlisensi di bawah [lisensi MIT](https://opensource.org/licenses/MIT).
