# Laravel Conq

Aplikasi Laravel modern yang dibangun untuk kolaborasi dan pengembangan tim.

**Repository:** https://github.com/RacoonHQ/conq.git
**Referensi:** https://ai.studio/apps/drive/1RpnxHq9-ULK5tsZSv0fRpy4X6C5up75t?fullscreenApplet=true

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

## Cara untuk Team Contribute

### Untuk Tim Developer

#### 1. Persiapan Awal

- **Install tools yang dibutuhkan**:
  - PHP 8.2+
  - Composer
  - Node.js
  - Git
  - IDE/Editor (VS Code, PhpStorm, dll)

- **Setup repository**:
  ```bash
  git clone <repository-url>
  cd laravel-conq
  composer run setup
  ```

#### 2. Alur Kerja Development

1. **Ambil task dari project management** (Jira, Trello, dll)
2. **Buat branch baru**:
   ```bash
   git checkout -b feature/nama-feature
   ```
3. **Develop sesuai requirement**
4. **Test secara lokal**:
   ```bash
   composer run test
   ```
5. **Commit dengan format yang benar**:
   ```bash
   git add .
   git commit -m "feat(module): tambahkan fitur baru"
   ```
6. **Push dan buat Pull Request**

#### 3. Code Review Process

- **Setiap PR harus di-review** oleh minimal 1 team member
- **Checklist review**:
  - Code follows PSR-12 standards
  - Tests are included and passing
  - Documentation is updated
  - No hardcoded values
  - Security considerations addressed

#### 4. Deployment

- **Development**: Auto-deploy ke development server setiap merge ke `develop`
- **Staging**: Manual deploy ke staging setelah approval
- **Production**: Manual deploy ke production dengan schedule

### Untuk Tim QA

#### 1. Testing Process

- **Unit Testing**: Developer responsibility
- **Integration Testing**: QA team verification
- **User Acceptance Testing**: Business user validation

#### 2. Bug Reporting

Gunakan format berikut untuk bug report:

```
**Title**: [Bug Type] - Brief Description
**Environment**: Development/Staging/Production
**Browser**: Chrome/Firefox/Safari
**Steps to Reproduce**:
1. Step 1
2. Step 2
3. Step 3
**Expected Result**: What should happen
**Actual Result**: What actually happened
**Screenshots**: [Attach if applicable]
```

### Untuk Tim Product/Designer

#### 1. Design Integration

- **Design files** disimpan di shared folder (Figma, Adobe XD)
- **Component library** menggunakan Blade components
- **CSS framework**: Tailwind CSS

#### 2. Content Management

- **Static content**: Edit di language files (`resources/lang`)
- **Dynamic content**: Manage melalui admin panel
- **Images**: Upload melalui media manager

### Communication Guidelines

#### 1. Daily Standup

- **Time**: Setiap hari pukul 09:00
- **Format**: What did yesterday, What today, Any blockers
- **Duration**: Max 15 menit

#### 2. Sprint Planning

- **Frequency**: Setiap 2 minggu
- **Participants**: Seluruh development team
- **Output**: Sprint backlog dengan task breakdown

#### 3. Retrospective

- **Frequency**: Akhir setiap sprint
- **Focus**: Process improvement
- **Action items**: Documented dan tracked

### Best Practices

#### 1. Code Quality

- **Follow PSR-12** coding standards
- **Write tests** untuk semua fitur baru
- **Use type hints** untuk parameter dan return values
- **Keep methods small** dan focused

#### 2. Security

- **Validate all input** data
- **Use prepared statements** untuk database queries
- **Implement proper authentication** dan authorization
- **Keep dependencies updated**

#### 3. Performance

- **Use caching** untuk data yang sering diakses
- **Optimize database queries**
- **Implement lazy loading** untuk relationships
- **Monitor application performance**

## Support

For questions or support:
- Create an issue in the repository
- Contact the development team
- Check the Laravel documentation at [https://laravel.com/docs](https://laravel.com/docs)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
