## Kreator

Proyek ini dibuat dan dikelola oleh:

* **Nama :  Arga Bona Simarmata**
* **NPM : 4523210020** 
# Portal Berita Sederhana (Laravel + Filament)

Ini adalah proyek aplikasi web *full-stack* yang dibangun menggunakan **Laravel 11** dan **Filament 3**. Proyek ini mencakup dua bagian utama:
1.  **Frontend Publik:** Sebuah portal berita, lengkap dengan halaman utama dinamis dan halaman detail artikel (termasuk sistem komentar).
2.  **Backend (Panel Admin):** Panel administrasi lengkap untuk mengelola Wartawan, Berita, dan **Komentar**.

---

## TUGAS

Bagian ini menjelaskan secara rinci bagaimana setiap poin yang telah diimplementasikan dalam panel admin.

### 1. Membuat Daftar Komentar
Halaman administrasi untuk komentar telah dibuat menggunakan *resource* dari Filament.
* **Implementasi:** Perintah `php artisan make:filament-resource Komentar` dijalankan untuk membuat file-file yang diperlukan.
* <img width="517" height="227" alt="image" src="https://github.com/user-attachments/assets/4f6aede3-eb39-4a61-a66d-91df8da40fb0" />
* **File Utama:** `app/Filament/Resources/KomentarResource.php`
* <img width="1918" height="743" alt="image" src="https://github.com/user-attachments/assets/26de914b-5391-4141-9b0c-d101512d58fb" />

### 2. Kolom: Judul Berita, Nama Komentator, Isi Komentar
Ketiga kolom yang diminta telah diimplementasikan dalam metode `table()` di `KomentarResource.php`.
<img width="779" height="711" alt="image" src="https://github.com/user-attachments/assets/cc31288c-c2ce-4df0-bf82-3319092ae242" />

* **Implementasi Teknis:**
    * **Judul Berita:** Menggunakan relasi Eloquent (`news`) untuk mengambil data dari tabel `news`.
    * **Nama Komentator & Isi:** Mengambil data langsung dari tabel `komentar`.

* **Kode (`app/Filament/Resources/KomentarResource.php`):**
    ```php
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom 1: Judul Berita (dari relasi)
                TextColumn::make('news.judul')
                    ->label('Judul Berita') 
                    ->sortable()
                    ->searchable()
                    ->limit(50),

                // Kolom 2: Nama Komentator
                TextColumn::make('nama')
                    ->label('Nama Komentator') 
                    ->sortable()
                    ->searchable(),

                // Kolom 3: Isi Komentar
                TextColumn::make('isi')
                    ->label('Isi Komentar')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
            ])
            // ...
    }
    ```

### 3. Form Action (Hapus Saja)
Sesuai arahan pada soal, fungsionalitas halaman ini dibatasi hanya untuk **melihat** dan **menghapus**. Semua fitur "Create" (Buat) dan "Edit" (Ubah) telah dihilangkan.
<img width="1916" height="794" alt="image" src="https://github.com/user-attachments/assets/c3451adb-3b03-4ed0-8f11-5025b432c3f8" />

* **Implementasi Teknis:**
    1.  **Menghilangkan Tombol "Create" (Pojok Kanan Atas):**
        * Metode `getHeaderActions()` di file `app/Filament/Resources/KomentarResource/Pages/ListKomentars.php` di-override untuk mengembalikan array kosong.
        ```php
        // app/Filament/Resources/KomentarResource/Pages/ListKomentars.php
        protected function getHeaderActions(): array
        {
            return []; // Mengembalikan array kosong
        }
        ```
    2.  **Menghilangkan Aksi "Edit":**
        * Dalam metode `table()` di `KomentarResource.php`, hanya `DeleteAction::make()` yang disertakan dalam array `actions()`.
        ```php
        // app/Filament/Resources/KomentarResource.php
        ->actions([
            Tables\Actions\DeleteAction::make(), // HANYA HAPUS
            // Tables\Actions\EditAction::make(), // Aksi Edit dinonaktifkan
        ])
        ```
    3.  **Menonaktifkan Halaman "Create" dan "Edit":**
        * Route untuk halaman `create` dan `edit` telah dihapus dari metode `getPages()` untuk mencegah akses langsung melalui URL.
        ```php
        // app/Filament/Resources/KomentarResource.php
        public static function getPages(): array
        {
            return [
                'index' => Pages\ListKomentars::route('/'),
                // 'create' => Pages\CreateKomentar::route('/create'), // Dinonaktifkan
                // 'edit' => Pages\EditKomentar::route('/{record}/edit'), // Dinonaktifkan
            ];
        }
        ```

### 4. Sort (Pengurutan)
Semua kolom yang diminta (Judul Berita, Nama Komentator, Isi Komentar) memiliki fungsionalitas *sorting* (pengurutan).

* **Implementasi Teknis:**
    * Metode `.sortable()` telah ditambahkan ke setiap `TextColumn` di dalam `table()`, seperti yang terlihat pada cuplikan kode di Poin 2. Ini secara otomatis mengaktifkan *header* kolom yang dapat diklik untuk mengurutkan data.

# Ascending
## Berdasarkan Judul
<img width="1472" height="373" alt="image" src="https://github.com/user-attachments/assets/b222252d-5c6a-4fff-b461-37cf73925e1f" />

## Berdasarkan Nama Komentator
<img width="1919" height="731" alt="image" src="https://github.com/user-attachments/assets/ed15cb24-a70b-434c-ae6d-1d4f40e1d436" />

## Berdasarkan Isi Komentar
<img width="1919" height="772" alt="image" src="https://github.com/user-attachments/assets/64f8c406-ed58-4e09-8bf4-9ebec32c832d" />

# Descending
## Berdasarkan Judul
<img width="1919" height="733" alt="image" src="https://github.com/user-attachments/assets/1cab0be1-0a77-4ee1-95b4-c994cc5141e5" />

## Berdasarkan Nama Komentator
<img width="1916" height="717" alt="image" src="https://github.com/user-attachments/assets/e085795a-a8a7-4b49-b852-c79bd4f81bcb" />

## Berdasarkan Isi Komentar
<img width="1919" height="798" alt="image" src="https://github.com/user-attachments/assets/28ce846c-83d0-49e5-a5ea-3616336f8a29" />

---

## Screenshot Aplikasi

#### 1. Panel Admin - Halaman Komentar
<img width="1919" height="728" alt="image" src="https://github.com/user-attachments/assets/50cbf0fb-c011-4c2f-80b0-5f7cd9407d48" />

#### 2. Frontend - Halaman Depan
<img width="1919" height="833" alt="image" src="https://github.com/user-attachments/assets/d2ba67fd-eac7-43ac-bb5e-456e6294601c" />

#### 3. Frontend - Halaman Detail Berita
<img width="1917" height="809" alt="image" src="https://github.com/user-attachments/assets/808f9889-035e-4b6d-b5d3-020ab9d048da" />
<img width="1919" height="851" alt="image" src="https://github.com/user-attachments/assets/f5dddc4d-77d4-47a0-99bf-840584bf53b5" />

---

## 🛠️ Teknologi yang Digunakan

* **Framework PHP:** Laravel 11
* **Admin Panel:** Filament 3
* **Styling:** TailwindCSS 
* **Database:** MySQL 
* **Bundler:** Vite

---

## 🚀 Instalasi & Setup Lokal

1.  **Clone repositori:**
    ```bash
    git clone [MASUKKAN URL REPO ANDA DI SINI]
    cd [nama-folder-proyek]
    ```

2.  **Instal Dependensi:**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Konfigurasi Database:**
    * Buat database baru (misal: `portal_berita_db`).
    * Atur koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD) di file `.env`.

5.  **Migrasi dan Seeding (Wajib):**
    * Perintah ini akan membuat semua tabel *dan* mengisinya dengan data *dummy* (Wartawan, Berita, Komentar) agar aplikasi siap digunakan.
    ```bash
    php artisan migrate --seed
    ```

6.  **Jalankan Server (Wajib 2 Terminal):**
    * **Terminal 1 (PHP Server):**
        ```bash
        php artisan serve
        ```
    * **Terminal 2 (Vite CSS/JS Server):**
        ```bash
        npm run dev
        ```

Aplikasi frontend sekarang berjalan di `http://127.0.0.1:8000`.

---

## 🔑 Akun Admin

Panel admin dapat diakses di `http://127.0.0.1:8000/admin`.

*Seeder* tidak membuat akun admin. Anda harus membuatnya secara manual:

```bash
php artisan make:filament-user
