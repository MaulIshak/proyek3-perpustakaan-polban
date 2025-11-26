<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\BookingBuku;
use App\Models\Photo;
use Carbon\Carbon;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Mengambil Statistik Utama (Counts)
        $totalBerita = Article::where('type', 'berita')->count();

        // Hitung berita bulan ini untuk "Trend"
        $beritaBulanIni = Article::where('type', 'berita')
            ->whereMonth('created_date', Carbon::now()->month)
            ->whereYear('created_date', Carbon::now()->year)
            ->count();

        $totalPengumuman = Article::where('type', 'pengumuman')->count();
        $pengumumanBulanIni = Article::where('type', 'pengumuman')
            ->whereMonth('created_date', Carbon::now()->month)
            ->count();

        $totalGaleri = Photo::where('tipe', 'galeri')->count();
        $galeriBaru = Photo::where('tipe', 'galeri')
            ->where('created_date', '>=', Carbon::now()->subDays(7))
            ->count();

        $pendingBooking = BookingBuku::where('status', 'pending')->count();

        // 2. Mengambil "Recent Activities" (Gabungan dari Artikel & Booking)
        // Ambil 5 artikel terbaru
        $latestArticles = Article::latest('created_date')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->article_id,
                    'type' => ucfirst($item->type), // Berita / Pengumuman
                    'title' => $item->judul,
                    'status' => $item->status, // Published / Draft
                    'time_raw' => $item->created_date, // Untuk sorting
                    'icon_type' => $item->type === 'berita' ? 'Newspaper' : 'Megaphone',
                    'bg_icon' => $item->type === 'berita' ? 'bg-emerald-100 text-emerald-600' : 'bg-sky-100 text-sky-600',
                ];
            });

        // Ambil 5 booking terbaru
        $latestBookings = BookingBuku::latest('created_at')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'Booking',
                    'title' => "Permintaan: {$item->judul_buku} oleh {$item->nama_lengkap}",
                    'status' => ucfirst($item->status),
                    'time_raw' => $item->created_at,
                    'icon_type' => 'BookOpen',
                    'bg_icon' => 'bg-violet-100 text-violet-600',
                ];
            });

        // Ambil 5 foto terbaru
         $latestPhotos = Photo::where('tipe', 'galeri')
            ->latest('created_date')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->foto_id,
                    'type' => 'Galeri',
                    'title' => "Upload Foto Baru",
                    'status' => 'Uploaded',
                    'time_raw' => $item->created_date,
                    'icon_type' => 'Image',
                    'bg_icon' => 'bg-amber-100 text-amber-600',
                ];
            });

        // Gabungkan, Sort berdasarkan waktu terbaru, dan Ambil 5-8 teratas
        $activities = $latestArticles->merge($latestBookings)->merge($latestPhotos)
            ->sortByDesc('time_raw')
            ->take(4)
            ->values(); // Reset keys agar jadi array JSON murni
            // $data = [
            //     'berita' => [
            //         'total' => $totalBerita,
            //         'trend' => $beritaBulanIni > 0 ? "+{$beritaBulanIni} bulan ini" : "0 bulan ini"
            //     ],
            //     'pengumuman' => [
            //         'total' => $totalPengumuman,
            //         'trend' => $pengumumanBulanIni > 0 ? "+{$pengumumanBulanIni} bulan ini" : "Stabil"
            //     ],
            //     'galeri' => [
            //         'total' => $totalGaleri,
            //         'trend' => $galeriBaru > 0 ? "+{$galeriBaru} baru minggu ini" : "Tidak ada baru"
            //     ],
            //     'booking' => [
            //         'total' => $pendingBooking,
            //         'trend' => 'Menunggu konfirmasi'
            //     ],
            //     'recentActivities' => $activities
            //     ];
            //     dd($data);
        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'berita' => [
                    'total' => $totalBerita,
                    'trend' => $beritaBulanIni > 0 ? "+{$beritaBulanIni} bulan ini" : "0 bulan ini"
                ],
                'pengumuman' => [
                    'total' => $totalPengumuman,
                    'trend' => $pengumumanBulanIni > 0 ? "+{$pengumumanBulanIni} bulan ini" : "Stabil"
                ],
                'galeri' => [
                    'total' => $totalGaleri,
                    'trend' => $galeriBaru > 0 ? "+{$galeriBaru} baru minggu ini" : "Tidak ada baru"
                ],
                'booking' => [
                    'total' => $pendingBooking,
                    'trend' => 'Menunggu konfirmasi'
                ]
            ],
            'recentActivities' => $activities
        ]);
    }
}
