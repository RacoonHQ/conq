# Panduan Kontribusi

Terima kasih atas minat Anda untuk berkontribusi pada proyek Laravel Conq! Dokumen ini menyediakan panduan untuk berkontribusi pada proyek ini, memastikan kolaborasi yang efektif dan kualitas kode yang tinggi.

## Daftar Isi

- [Alur Kerja Pengembangan](#alur-kerja-pengembangan)
- [Panduan Git](#panduan-git)
  - [Konvensi Penamaan Branch](#konvensi-penamaan-branch)
  - [Format Pesan Commit](#format-pesan-commit)
- [Proses Pull Request](#proses-pull-request)
- [Standar Kualitas Kode](#standar-kualitas-kode)
- [Panduan untuk Tim](#panduan-untuk-tim)
  - [Developer](#untuk-tim-developer)
  - [QA & Testing](#untuk-tim-qa)
  - [Product & Designer](#untuk-tim-productdesigner)
- [Komunikasi & Best Practices](#komunikasi--best-practices)

---

## Alur Kerja Pengembangan

### Persiapan Awal

1. **Prasyarat**:
   - PHP 8.2+
   - Composer
   - Node.js
   - Database (MySQL/PostgreSQL/SQLite)
   - Git

2. **Setup Proyek**:
   ```bash
   git clone https://github.com/RacoonHQ/conq.git
   cd laravel-conq
   composer run setup
   ```

### Pengembangan Harian

1. **Mulai Environment**:
   ```bash
   composer run dev
   ```

2. **Testing & Formatting**:
   Selalu jalankan test dan formatter sebelum commit:
   ```bash
   composer run test
   vendor/bin/pint
   ```

---

## Panduan Git

### Konvensi Penamaan Branch

Gunakan format berikut untuk nama branch:

- `feature/nama-fitur` - Untuk fitur baru
- `bugfix/deskripsi-bug` - Untuk perbaikan bug
- `hotfix/perbaikan-kritis` - Untuk perbaikan kritis di production
- `refactor/perbaikan-kode` - Untuk refactoring kode
- `docs/update-dokumentasi` - Untuk perubahan dokumentasi

### Format Pesan Commit

Kami mengikuti spesifikasi [Conventional Commits](https://www.conventionalcommits.org/):

Format:
```
<tipe>[opsional scope]: <deskripsi>

[opsional body]
```

**Tipe yang digunakan:**
- `feat`: Fitur baru
- `fix`: Perbaikan bug
- `docs`: Dokumentasi
- `style`: Perubahan format/style (spasi, formatting, dll)
- `refactor`: Perubahan kode yang bukan fix atau fitur
- `test`: Menambah atau update test
- `chore`: Tugas maintenance (build tasks, package manager configs, dll)

**Contoh:**
```
feat(auth): tambahkan autentikasi dua faktor
fix(api): perbaiki error pada endpoint user profile
docs(readme): update instruksi instalasi
```

---

## Proses Pull Request

1. **Buat Branch**: Selalu buat branch baru dari `main` atau `develop` (sesuai kesepakatan tim).
2. **Commit Perubahan**: Lakukan perubahan atomik dengan pesan commit yang jelas.
3. **Sync**: Pastikan branch Anda up-to-date dengan upstream sebelum membuat PR.
4. **Buat PR**: Push ke repository dan buat Pull Request.
5. **Deskripsi**: Isi deskripsi PR dengan jelas, referensikan issue terkait jika ada.
6. **Review**: Tunggu review dari minimal 1 anggota tim. Perbaiki jika ada feedback.
7. **Merge**: Setelah disetujui, PR dapat di-merge.

---

## Standar Kualitas Kode

- **PSR-12**: Ikuti standar coding style PHP [PSR-12](https://www.php-fig.org/psr/psr-12/).
- **Testing**:
  - Tulis unit/feature test untuk setiap fitur baru atau perbaikan bug.
  - Coverage test harus dipertahankan atau ditingkatkan.
- **Formatting**: Gunakan Laravel Pint (`vendor/bin/pint`) untuk memastikan konsistensi kode.
- **Clean Code**:
  - Metode harus kecil dan fokus (Single Responsibility).
  - Gunakan type hinting pada parameter dan return value.
  - Hindari hardcoded values, gunakan config atau constants.

---

## Panduan untuk Tim

### Untuk Tim Developer

1. **Alur Kerja**:
   - Ambil task dari Project Management (Jira/Trello).
   - Buat branch sesuai task ID atau nama fitur.
   - Develop, Test Lokal, Commit, Push.
2. **Code Review**:
   - Cek apakah kode mengikuti standar.
   - Pastikan logic aman dan efisien.
   - Pastikan tidak ada credential yang ter-commit.

### Untuk Tim QA

1. **Testing Process**:
   - **Unit Testing**: Tanggung jawab Developer.
   - **Integration Testing**: Verifikasi tim QA.
   - **UAT**: Validasi user/owner.
2. **Bug Reporting**:
   Gunakan template berikut saat melaporkan bug:
   ```
   **Title**: [Tipe Bug] - Deskripsi Singkat
   **Environment**: Dev/Staging/Prod
   **Steps to Reproduce**:
   1. Langkah 1
   2. Langkah 2...
   **Expected Result**: ...
   **Actual Result**: ...
   **Screenshots/Logs**: ...
   ```

### Untuk Tim Product/Designer

1. **Design Integration**:
   - Aset desain di Figma/Adobe XD.
   - Implementasi menggunakan Tailwind CSS.
2. **Konten**:
   - Teks statis diatur di file language (`resources/lang`).
   - Konten dinamis via Admin Panel.

---

## Komunikasi & Best Practices

### Komunikasi
- **Daily Standup**: Update progress kemarin, rencana hari ini, dan blockers.
- **Sprint Planning**: Perencanaan 2 mingguan.
- **Retrospective**: Evaluasi proses di akhir sprint.

### Security Best Practices
- Validasi semua input pengguna.
- Gunakan Prepared Statements / Eloquent untuk database.
- Terapkan otorisasi (Policies/Gates) dengan benar.
- Jaga dependensi tetap update.

### Performance
- Gunakan Caching untuk data berat.
- Optimalkan query database (hindari N+1 problem).
- Gunakan Queue untuk proses berat di background.
