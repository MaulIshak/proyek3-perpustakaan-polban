<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
                // [FIX] Gunakan config(), bukan env()
                return new BrevoService(
                    config('services.brevo.key'),
                    'TANYA PUSTAKAWAN',
                    config('services.brevo.sender_email')
                );
            });

        // 2. Konfigurasi untuk BOOKING BUKU
        $this->app->when(BookingController::class)
            ->needs(BrevoService::class)
            ->give(function () {
                // [FIX] Gunakan config(), bukan env()
                return new BrevoService(
                    config('services.brevo.key'),
                    'Layanan Sirkulasi Perpustakaan Polban',
                    config('services.brevo.sender_email')
                );
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}