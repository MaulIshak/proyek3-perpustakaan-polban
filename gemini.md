# Proyek Perpustakaan POLBAN

Ini adalah sistem manajemen perpustakaan untuk Politeknik Negeri Bandung (POLBAN). Proyek ini dibangun menggunakan Laravel, Vue.js, dan Inertia.js.

## Ringkasan Proyek

Sistem ini menyediakan platform bagi mahasiswa dan staf untuk mengelola peminjaman buku, melihat katalog, dan mengakses layanan perpustakaan lainnya. Ini juga mencakup dasbor admin untuk mengelola artikel (berita) dan konten lainnya.

## Teknologi yang Digunakan

*   **Backend:** Laravel
*   **Frontend:** Vue.js
*   **Framework:** Inertia.js
*   **Styling:** Tailwind CSS
*   **Build Tool:** Vite

## Cara Menjalankan Proyek

1.  **Clone repositori:**

    ```bash
    git clone <URL_REPOSITORI>
    ```

2.  **Install dependensi:**

    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi environment:**

    Salin file `.env.example` menjadi `.env` dan konfigurasi database Anda.

    ```bash
    cp .env.example .env
    ```

4.  **Generate kunci aplikasi:**

    ```bash
    php artisan key:generate
    ```

5.  **Jalankan migrasi database:**

    ```bash
    php artisan migrate
    ```

6.  **Jalankan server pengembangan:**

    Gunakan skrip `dev` dari `composer.json` untuk menjalankan server PHP, antrian, dan Vite secara bersamaan.

    ```bash
    composer run dev
    ```

    Atau, jalankan secara manual:

    ```bash
    php artisan serve
    ```

    Dan di terminal lain, jalankan:

    ```bash
    npm run dev
    ```

7.  **Akses aplikasi:**

    Buka browser Anda dan kunjungi `http://localhost:8000`.

## Struktur Direktori

*   `app/`: Berisi semua logika sisi server (controller, model, dll.).
*   `resources/js/`: Berisi semua komponen Vue.js, halaman, dan aset frontend lainnya.
*   `routes/`: Berisi definisi rute untuk web dan admin.
*   `database/`: Berisi migrasi dan seeder database.
*   `public/`: Titik masuk publik untuk aplikasi.
