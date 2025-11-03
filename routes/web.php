<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/about', function () {
    $data = [
        'title' => 'Tentang Perpustakaan',
        'subjudul_1' => 'Sejarah',
        'subjudul_2' => 'Visi',
        'subjudul_3' => 'Misi',
        'misi' => [
            'Menyediakan koleksi bahan pustaka yang relevan dan mutakhir dalam berbagai format untuk mendukung proses pembelajaran, penelitian, dan pengabdian kepada masyarakat.',
            'Memberikan layanan prima dan akses informasi yang mudah, cepat, dan tepat guna bagi seluruh civitas akademika.',
            'Mengembangkan fasilitas perpustakaan yang nyaman dan kondusif dengan memanfaatkan teknologi informasi dan komunikasi.',
            'Meningkatkan literasi informasi pemustaka melalui program edukasi dan bimbingan pemakai.',
        ],
    ];
    return Inertia::render('user/Profile/About', $data);
});

Route::get('/facilities', function () {
    $data = [
        'title' => 'Fasilitas Perpustakaan',
        'subtitle' => 'Berbagai fasilitas modern untuk mendukung kegiatan belajar Anda',
        'facilities' => [
            [
                'subjudul' => 'Ruang Baca',
                'description' => 'Ruang baca dengan kapasitas 150 orang, dilengkapi dengan AC, pencahayaan yang baik, dan suasana tenang untuk mendukung aktivitas belajar mandiri.',
                'image' => 'https://library.polban.ac.id/wp-content/uploads/2024/09/Screenshot-2024-09-12-124117-10-1024x511.png',
            ],
            [
                'subjudul' => 'Ruang Komputer',
                'description' => 'Fasilitas 40 unit komputer dengan akses internet cepat, tersedia untuk browsing, mengakses e-journal, dan mengerjakan tugas.',
                'image' => 'https://library.polban.ac.id/wp-content/uploads/2024/09/Ruang-Baca-7-1024x682.jpg',
            ],
        ],
    ];

    return Inertia::render('user/Profile/Facilities', $data);
});

Route::get('/tim-manajemen', function () {
    $data = [
        'title' => 'Tim Manajemen'
    ];

    return Inertia::render('user/Profile/TimManajemen', $data);
});


require __DIR__ . '/settings.php';
