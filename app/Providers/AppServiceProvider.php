<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BrevoService;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\BookingController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 1. Konfigurasi untuk TANYA PUSTAKAWAN
        $this->app->when(QuestionController::class)
            ->needs(BrevoService::class)
            ->give(function () {
                return new BrevoService(
                    env('BREVO_API_KEY'),       // API Key Utama
                    'TANYA PUSTAKAWAN',         // <--- NAMA KHUSUS
                    env('BREVO_SENDER_EMAIL')   // Email Utama (Harus Verified)
                );
            });

        // 2. Konfigurasi untuk BOOKING BUKU
        $this->app->when(BookingController::class)
            ->needs(BrevoService::class)
            ->give(function () {
                return new BrevoService(
                    env('BREVO_API_KEY'),                    // API Key Utama (SAMA)
                    'Layanan Sirkulasi Perpustakaan Polban', // <--- NAMA BEDA
                    env('BREVO_SENDER_EMAIL')                // Email Utama (SAMA)
                );
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}