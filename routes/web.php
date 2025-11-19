<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CoverBuku;
use App\Http\Controllers\RencanaStrategi;
use App\Http\Controllers\TimManajemen;

Route::get('/pelayanan/{slug}', function (string $slug) {
    return Inertia::render('Pelayanan/Show', [
        'pelayanan' => $slug
    ]);
});

Route::get('/bebas_masalah', function () {
    return Inertia::render('BebasMasalah/Bebas_Masalah');
});

Route::get('/gallery', function() {
    return Inertia::render('Galeri/Galeri');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    $data = [
        'title' => 'Tentang Perpustakaan',
        'subjudul_1' => 'Sejarah',
        'subjudul_2' => 'Visi',
        'subjudul_3' => 'Misi',
        'misi' => [
            'Menyediakan koleksi mutakhir dan pelayanan yang efektif dengan memberikan akses informasi 24 jam.',
            'Menyediakan berbagai pilihan fasilitas belajar mandiri untuk mencapai prestasi akademik yang optimal.'
        ],
    ];
    return Inertia::render('user/Profile/About', $data);
});

// Fasilitas
Route::get('/facilities', function () {
    $data = [
        'title' => 'Fasilitas Perpustakaan',
        'subtitle' => 'Berbagai fasilitas modern untuk mendukung kegiatan belajar Anda',
        'facilities' => [
            [
                'subjudul' => 'Ruang Sirkulasi',
                'description' => 'Fasilitas 40 unit komputer dengan akses internet cepat, tersedia untuk browsing, mengakses e-journal, dan mengerjakan tugas.',
                'image' => 'https://library.polban.ac.id/wp-content/uploads/2024/09/Screenshot-2024-09-12-124117-10-1024x511.png',
            ],
            [
                'subjudul' => 'Ruang Baca',
                'description' => 'Ruang baca dengan kapasitas 150 orang, dilengkapi dengan AC, pencahayaan yang baik, dan suasana tenang untuk mendukung aktivitas belajar mandiri.',
                'image' => 'https://library.polban.ac.id/wp-content/uploads/2024/09/Ruang-Baca-7-1024x682.jpg',
            ],
            [
                'subjudul' => 'Ruang Referensi',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi quia a maxime quisquam impedit qui velit optio iusto. Voluptas beatae similique corporis ex ipsam eveniet assumenda, possimus nobis distinctio.',
                'image' => 'https://library.polban.ac.id/wp-content/uploads/2024/09/Screenshot-2024-09-12-124117-10-1024x511.png'
            ],
            [
                'subjudul' => 'Ruang Komputer',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi quia a maxime quisquam impedit qui velit optio iusto. Voluptas beatae similique corporis ex ipsam eveniet assumenda, possimus nobis distinctio.',
                'image' => 'https://library.polban.ac.id/wp-content/uploads/2024/09/Screenshot-2024-09-12-124117-10-1024x511.png'
            ],
            [
                'subjudul' => 'Ruang Belajar Mandiri',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi quia a maxime quisquam impedit qui velit optio iusto. Voluptas beatae similique corporis ex ipsam eveniet assumenda, possimus nobis distinctio.',
                'image' => 'https://library.polban.ac.id/wp-content/uploads/2024/09/Screenshot-2024-09-12-124117-10-1024x511.png'
            ],
            [
                'subjudul' => 'Ruang Loker',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi quia a maxime quisquam impedit qui velit optio iusto. Voluptas beatae similique corporis ex ipsam eveniet assumenda, possimus nobis distinctio.',
                'image' => 'https://library.polban.ac.id/wp-content/uploads/2024/09/Screenshot-2024-09-12-124117-10-1024x511.png'
            ]
        ],
    ];

    return Inertia::render('user/Profile/Facilities', $data);
});

// Tim Manajemen User
Route::get('/tim-manajemen', [TimManajemen::class, 'timManajemen'])->name('tim manajemen');

// Kontak User
Route::get('/contact', function () {
    $data = [
        'title' => 'Hubungi Kami',
        'subjudul' => 'Informasi Kontak'
    ];

    return Inertia::render('user/Kontak/Kontak', $data);
});

Route::get('/usulan_buku', function () {
    return Inertia::render('user/Koleksi/Usulan_Buku');
});

Route::get('/E_Journal', function () {
    return Inertia::render('user/Koleksi/EJournal');
});

Route::get('/berita', [ArticleController::class, 'beritaUser'])->name('beritaUser');
Route::get('/pengumuman', [ArticleController::class, 'pengumumanUser'])->name('pengumumanUser');

// Peraturan Perpustakaan
Route::get('/peraturan', function (){
    $data = [
        'title' => 'Peraturan Perpustakaan'
    ];

    return Inertia::render('user/Profile/Peraturan', $data);
});

// Jam Layanan
Route::get('/jam-layanan', function (){
    $data = [
        'title' => 'Jam Layanan',
        
    ];

    return Inertia::render('user/Profile/JamLayanan', $data);
});

// Booking Buku 
Route::get('/book-reservation', function(){
    $data = [
        'title' => 'Booking buku'
    ];

    return Inertia::render('user/BookingBuku', $data);
});

// Renstra
Route::get('/renstra', [RencanaStrategi::class, 'viewPDF'])->name('renstra');


// Cover Buku Baru USER
// Route::get('/')


Route::prefix('admin')->name('admin.')->group(function () {
    // show login form (only for guests of admin guard)
    Route::get('login', [LoginController::class, 'showLogin'])->middleware('guest.admin')->name('login');

    // perform login
    Route::post('login', [LoginController::class, 'login'])->name('login.post');

    // logout
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:admin')->name('logout');

    // admin dashboard (protected)
    Route::get('dashboard', function () {
        return Inertia::render('admin/Dashboard');
    })->middleware('auth:admin')->name('dashboard');

    // Berita
    Route::get('berita', [ArticleController::class, 'index'])->middleware('auth:admin')->name('beritaIndex');
    Route::get('berita/create', function(){
        return Inertia::render('admin/berita/Create');
    })->middleware('auth:admin')->name('beritaCreate');

    Route::post('berita/store', [ArticleController::class, 'storeBerita'])
    ->middleware('auth:admin')
    ->name('beritaStore');

    Route::get('berita/detail/{id}', [ArticleController::class, 'showBerita'])->middleware('auth:admin')->name('beritaShow');

    // Tim manajemen
    Route::get('tim-manajemen', [TimManajemen::class, 'TmAdminPage'])->middleware('auth:admin')->name('tim.index');
    Route::post('tim-manajemen/store', [TimManajemen::class, 'store'])->middleware('auth:admin')->name('tim.store');
    Route::put('tim-manajemen/update/{id}', [TimManajemen::class, 'update'])->middleware('auth:admin')->name('tim.update');
    Route::delete('tim-manajemen/delete/{id}', [TimManajemen::class, 'destroy'])->middleware('auth:admin')->name('tim.destroy');

    // Renstra
    Route::get('renstra', [RencanaStrategi::class, 'index'])->middleware('auth:admin')->name('renstra.index');
    Route::post('renstra/store', [RencanaStrategi::class, 'store'])->middleware('auth:admin')->name('renstra.store');
    Route::put('renstra/update/{id}', [RencanaStrategi::class, 'update'])->middleware('auth:admin')->name('renstra.update');
    Route::delete('renstra/delete/{id}', [RencanaStrategi::class, 'destroy'])->middleware('auth:admin')->name('renstra.destroy');

    // Cover Buku
    Route::get('cover-buku', [CoverBuku::class, 'index'])->name('cover.index');
    Route::post('cover-buku/store', [CoverBuku::class, 'store'])->name('cover.store');
    // Kita pakai POST untuk update file (dengan _method: PUT di frontend)
    Route::post('cover-buku/update/{id}', [CoverBuku::class, 'update'])->name('cover.update');
    Route::delete('cover-buku/delete/{id}', [CoverBuku::class, 'destroy'])->name('cover.destroy');
});

require __DIR__.'/settings.php';
