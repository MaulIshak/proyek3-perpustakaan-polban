# Proyek Perpustakaan POLBAN

Ini adalah sistem manajemen perpustakaan untuk Politeknik Negeri Bandung (POLBAN). Proyek ini dibangun menggunakan Laravel, Vue.js, dan Inertia.js.

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

4.  **Jalankan migrasi database:**

    ```bash
    php artisan migrate
    ```

5.  **Jalankan server pengembangan:**

    ```bash
    php artisan serve
    ```

    Dan di terminal lain, jalankan:

    ```bash
    npm run dev
    ```

6.  **Akses aplikasi:**

    Buka browser Anda dan kunjungi `http://localhost:8000`.
